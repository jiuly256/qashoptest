<?php
/**
 * Controlador para dado dos archivos unificarlos en uno solo
*/
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;

class CsvController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['upload','view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

/**
* Funcion para cargar y convertir archivo xml a csv
*/
public function actionUpload()
{
    $model = new UploadForm();
    $model->scenario = 'csvfile';

    if (Yii::$app->request->isPost) {
        $model->file = UploadedFile::getInstance($model, 'file'); // carga archivo
        $model->file2 = UploadedFile::getInstance($model, 'file2'); // carga archivo 2

        if ($model->validate()) {   
            $csv_file_path1='../files/' . $model->file->baseName . '.' . $model->file->extension;
            $csv_file_path2='../files/' . $model->file2->baseName . '.' . $model->file2->extension;
            $model->file->saveAs($csv_file_path1); // guarda el archivo
            $model->file2->saveAs($csv_file_path2); // guarda el archivo 2
         
        // Lee CSV 1 y crea el primer contenido del csv    
        $content1=$this->readFile($csv_file_path1);
//        elimina la cabecera
        $header1 = array_shift($content1);
       
        // Lee CSV 2 y crea el segundo contenido del csv
        $content2 = $this->readFile($csv_file_path2);
//        elimina la cabecera
        $header2 = array_shift($content2);

        // une ambos header en uno solo
        $header = array_unique(array_merge($header1,$header2) );

        // fusiona el contenido de los csv
        $content = array_merge ($content1,$content2);

        return $this->render('view',['content' => $content,'header'=>$header]);
        
        }
    }

    return $this->render('upload', ['model' => $model]);
}
/**
 * Ver el csv
 */
public function actionView()
    {

        return $this->render('view');
    }

/**
 * funcion propia de php.net para cambiar los indices en un array
 */    
function change_index(&$tableau, $old_key, $new_key) {
    $changed = FALSE;    $temp = 0;
    
    foreach ($tableau as $key => $value) {
        switch ($changed) {
            case FALSE :
                //creates the new key and deletes the old
                if ($key == $old_key) {
                    $tableau[$new_key] = $tableau[$old_key];
                    unset($tableau[$old_key]);
                    $changed = TRUE;
                }
                break;

            case TRUE :
                //moves following keys
                if ($key != $new_key){
                $temp= $tableau[$key];
                unset($tableau[$key]);
                $tableau[$key] = $temp;
                break;
                }  else {$changed = FALSE;} //stop
        }
    }
    array_values($tableau); //free_memory
}
/**
 * funcion para leer el archivo csv y adecuarlo al yii2tech
 */  

function readFile($file){
    
        $content = [];
        $file = new \SplFileObject($file); 
        $file->setFlags(\SplFileObject::READ_CSV); // lee csv
        foreach ($file as $line) {
            $content[] = $line;
        }
        $count= count($content); // cuenta las filas
        $countValues = count($content[0]); //cuenta las columnas
        $i=0;
        for ($i=0;$i<$countValues;$i++){

            for ($j=1;$j<$count;$j++){
                $this->change_index ($content[$j], $i, $content[0][$i]); // cambia los indices
            }
        }
    return $content;
}
}
