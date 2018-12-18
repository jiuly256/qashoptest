<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'QaShpops Test';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>QaShpos</h1>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Refactoring</h2>

                <p style="text-align:justify">Tenemos la clase Product (Anexo 1) con un método llamado stock(). El código de dicho método
                realiza comprobaciones duplicadas y el código carece de bastante legibilidad. Refactoriza el
                método (creando métodos auxiliares, reordenando el código, renombrando variables, etc) para
                que se entienda mejor qué hace y sea más legible. Lo único que no se puede cambiar es la
                firma del método.</p>
                
                <code>Esta clase esta en models <strong>qashops-anexo_1</strong></code>
            </div>
            <div class="col-lg-4">
                <h2>Aplanamiento XML</h2>

                <p style="text-align:justify">Crear un metodo, que dado un path a un fichero XML, lo aplane y guarde en un csv.</p>

                <?= Html::a('Ir', ['xml/upload'], ['class' => 'btn btn-default']) ?>    
            </div>
            <div class="col-lg-4">
                <h2>Merge de dos ficheros CSV</h2>

                <p style="text-align:justify">Crear un método, que dado 2 paths de dos ficheros csv, los unifique en un solo fichero. Las
                cabeceras (asumimos que la cabecera está siempre en la primera fila) que estén en común en
                ambos ficheros deben estar unificadas y solo estar presentes una vez en el fichero devuelto</p>

                  <?= Html::a('Ir', ['csv/upload'], ['class' => 'btn btn-default']) ?>    
            </div>
        </div>

    </div>
</div>
