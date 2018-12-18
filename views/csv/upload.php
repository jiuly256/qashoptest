<?php

/* 
 * Vista para cargar los archivos csv
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Merge de dos ficheros CSV';
$this->params['breadcrumbs'][] = $this->title;

?>
    <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
    
<div class="row">
    <div class="col-lg-12">
        <div class="alert alert-warning">
            El nombre del archivo fusionado sera <strong>output.csv</strong><br/>
        </div>
        
        <?php 
        $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'file')->fileInput() ?>

        <?= $form->field($model, 'file2')->fileInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary', 'name' => 'enviar']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>  
</div>  