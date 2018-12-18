<?php

/* 
 * Tenemos la clase Product (Anexo 1) con un método llamado stock(). 
 * El código de dicho método realiza comprobaciones duplicadas
 *  y el código carece de bastante legibilidad. Refactoriza el método 
 * (creando métodos auxiliares, reordenando el código, renombrando variables, etc)
 *  para que se entienda mejor qué hace y sea más legible.
 *  Lo único que no se puede cambiar es la firma del método.
 */


class Product
{
public $db;
    
   // Obtenemos el stock bloqueado por pedidos en curso
    public function actionOrdersQuantity ($db,$productId,$cacheDuration=60,$cache=false){
        
         if ($cache) {
            $ordersQuantity = OrderLine::getDb()->cache(
                    function ($db) use ($productId) {
                        return OrderLine::find()->select('SUM(quantity) as quantity')->
                                joinWith('order')->where
                                ("(order.status = '" . Order::STATUS_PENDING . "' "
                                        . "OR order.status = '" . Order::STATUS_PROCESSING . "' "
                                        . "OR order.status = '" .Order::STATUS_WAITING_ACCEPTANCE . "') "
                                        . "AND order_line.product_id = $productId")->scalar();
                        },$cacheDuration
                    );
                        
         } else {
            $ordersQuantity = OrderLine::find()->select('SUM(quantity) as quantity')->
                    joinWith('order')->
                    where ("(order.status = '" . Order::STATUS_PENDING . "' "
                            . "OR order.status = '" . Order::STATUS_PROCESSING . "' "
                            . "OR order.status = '" . Order::STATUS_WAITING_ACCEPTANCE . "') "
                            . "AND order_line.product_id = $productId")->scalar();
         }
         return $ordersQuantity;
    }
   // Obtenemos el stock bloqueado
    public function actionBlockedStockQuantity ($db,$productId,$cacheDuration=60,$cache=false){
         if ($cache){
               
            $blockedStockQuantity = BlockedStock::getDb()->cache(
                    function ($db) use ($productId) {
                        return BlockedStock::find()->select('SUM(quantity) as quantity')->
                                joinWith('shoppingCart')->
                                where("blocked_stock.product_id = $productId "
                                        . "AND blocked_stock_date > '" . date('Y-m-d H:i:s') . "' "
                                        . "AND (shopping_cart_id IS NULL "
                                        . "OR shopping_cart.status = '" . ShoppingCart::STATUS_PENDING . "')")->scalar();
                        }, 
                    $cacheDuration);
         }else{
            $blockedStockQuantity = BlockedStock::find()->select('SUM(quantity) as quantity')->
                    joinWith('shoppingCart')->
                    where("blocked_stock.product_id = $productId "
                            . "AND blocked_stock_to_date > '" . date('Y-m-d H:i:s') . "' "
                            . "AND (shopping_cart_id IS NULL "
                            . "OR shopping_cart.status = '" . ShoppingCart::STATUS_PENDING . "')")->scalar();
         }
         
     }
     
    public function actionYesOrderBlocked ($quantityAvailable,$ordersQuantity,$blockedStockQuantity,$securityStockConfig){
           if ($quantityAvailable >= 0) {
                $quantity = $quantityAvailable - $ordersQuantity - $blockedStockQuantity;
                if (!empty($securityStockConfig)) {
                    $quantity = ShopChannel::applySecurityStockConfig($quantity,$securityStockConfig->mode,$securityStockConfig->quantity);
                }
                return $quantity > 0 ? $quantity : 0;
            }
            else{
                return $quantityAvailable;
            }
     }
     
    public function actionNoOrderBlocked($quantityAvailable,$securityStockConfig){
           if ($quantityAvailable >= 0) {
                if (!empty($securityStockConfig)) {
                    $quantityAvailable = ShopChannel::applySecurityStockConfig($quantityAvailable,$securityStockConfig->mode,$securityStockConfig->quantity);
                }
                $quantityAvailable = $quantityAvailable > 0 ? $quantityAvailable : 0;
            }
                return $quantityAvailable;
     }

    public static function stock(
             $productId,
             $quantityAvailable,
             $cache = false,
             $cacheDuration = 60,
             $securityStockConfig = null
             ){
        
        $ordersQuantity= $this->actionOrdersQuantity($db, $productId, $cacheDuration, $cache);

        $blockedStockQuantity=$this->actionBlockedStockQuantity($db, $productId, $cacheDuration, $cache);

        // Calculamos las unidades disponibles
        if (isset($ordersQuantity) || isset($blockedStockQuantity)):
            $this->actionYesOrderBlocked ($quantityAvailable,$ordersQuantity,$blockedStockQuantity,$securityStockConfig);
        else:
            $this->actionNoOrderBlocked($quantityAvailable,$securityStockConfig);
        endif;
        
        return 0;
    }
}

