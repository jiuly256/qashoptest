<?php
/**
 * vista resultado despues de recibir el xml y llama a la funcion de yii2tech
 * para exportar a csv
 * 
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii2tech\csvgrid\CsvGrid;
use yii\data\ArrayDataProvider;

$this->title = 'Convertir a CSV';
$this->params['breadcrumbs'][] = $this->title;
//echo "<pre>";
//print_r($content);
//echo "jiuly"; exit;
?>
<div>
    <h1><?= Html::encode($this->title) ?></h1>
  
    <?php
    /**
     *En el arreglo de allModels se colocan los datos hijos de los nodos del xml 
     *En columns la cabecera de como quedaria
     * 
     */
    $exporter = new CsvGrid([
    'dataProvider' => new ArrayDataProvider([
       'allModels' => $content,
    ]),
    'columns' => $header,
     'csvFileConfig' => [
        'cellDelimiter' => ";",
        'rowDelimiter' => "\n",
        'enclosure' => '',
    ],
]);
  
/**
 * Para exportar el archivo en formato csv y mostrar un boton si el cliente desea abrirlo
 *     
 */
if ($exporter->export()->saveAs('../files/'.$name.'.csv')){
    echo  '<div class="alert alert-success">
            El archivo <strong>'.$name.'.csv</strong> se ha cargado con exito.
        </div>';
    
   echo Html::a('Abrir archivo', ['../files/'.$name.'.csv'], ['class' => 'btn btn-default']);
}
?>
</div>
