<?php

/* 
 * Vista para cargar el archivo xml
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Aplanamiento XML';
$this->params['breadcrumbs'][] = $this->title;

?>
    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
    
<div class="row">
    <div class="col-lg-12">
        <div class="alert alert-warning">
            El nombre del archivo xml sera el nombre del archivo csv<br/>
            Ejemplo: <strong>producto.xml<strong> generará <strong>producto.csv<strong><br/>
        </div>
        
        <?php 
        $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'file')->fileInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary', 'name' => 'enviar']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>  
</div>  