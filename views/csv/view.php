<?php
/**
 * vista resultado despues de recibir los archivos csv y fusionarlo en uno solo
 * para exportar a csv usando la libreria yii2tech
 * 
 */

use yii\helpers\Html;
use yii2tech\csvgrid\CsvGrid;
use yii\data\ArrayDataProvider;

$this->title = 'output CSV';
$this->params['breadcrumbs'][] = $this->title;

?>
<div>
    <h1><?= Html::encode($this->title) ?></h1>
  
    <?php
    /**
     *En el arreglo de allModels se colocan el contenido del resultado de los csv
     *En columns el header del csv
     * 
     */
    $exporter = new CsvGrid([
    'dataProvider' => new ArrayDataProvider([
       'allModels' => $content,
    ]),
    'columns' => 
       $header,
    
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
if ($exporter->export()->saveAs('../files/output.csv')){
    echo  '<div class="alert alert-success">
            El archivo <strong>output.csv</strong> se ha cargado con exito.
        </div>';
    
   echo Html::a('Abrir archivo', ['../files/output.csv'], ['class' => 'btn btn-default']);
}
?>
</div>
