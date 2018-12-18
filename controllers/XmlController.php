<?php
/**
 * Controlador para recibir el archivo xml y convertirlo a csv
 * 
 *  */
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;



class XmlController extends Controller
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
    $model->scenario = 'xmlfile';

    if (Yii::$app->request->isPost) {
        $model->file = UploadedFile::getInstance($model, 'file'); // carga archivo
        
        if ($model->validate()) {   
            
            $model->file->saveAs('../files/' . $model->file->baseName . '.' . $model->file->extension); // guarda el archivo

             $name=$model->file->baseName; // nombre del archivo
             $file='../files/'.$name.'.xml'; // ubicacion del archivo
             
             // llama a la funcion loadXml para cargar el xml
             $xmlstring=$this->loadXml($file,$name);
             
             //define las claves padres e hijos
             foreach($xmlstring as $value)
                {
                  $keyFather = key($xmlstring);
                  $keyChildren = key($value);
                }

            $content= $this->loadContent($xmlstring,$keyFather,$keyChildren); // contenido del csv
            
            $header= $this->loadHeader($xmlstring,$keyFather,$keyChildren); // cabecera del csv
            
          
        return $this->render('view', ['name'=>$name,'content'=>$content,'header'=>$header]);
        
        }
    }

    return $this->render('upload', ['model' => $model]);
}
/**
 * Ver el csv generado
 */
public function actionView()
    {

        return $this->render('view');
    }
    


/* 
* Interpretar el Xml usando la funcion de php SimpleXml
*/
    function loadXml($file,$name){

         if (file_exists($file)){
                    $xmlstring = simplexml_load_file($file, "SimpleXMLElement", LIBXML_NOCDATA);
                 }  else{
                      exit('Error abriendo '.$name.'.xml');
                 } 
        return $xmlstring;         
}
/* 
* funcion que carga el contenido del csv
*/
    function loadContent($xmlstring,$keyFather,$keyChildren){

         $count=count($xmlstring->$keyFather->$keyChildren); // cuenta los registros del xml
             $values=[];
             for ($i=0; $i<$count;$i++){
                 $values[]=$xmlstring->$keyFather->$keyChildren[$i];
            }       
            $values1 = json_decode(json_encode($values), true); // elimina el SimpleXMLElement Object
            
        return $values1;         
}

/* 
* funcion que carga el header del csv
*/
    function loadHeader($xmlstring,$keyFather,$keyChildren){

             $keys=[];
             foreach ($xmlstring->$keyFather->$keyChildren as $element) {
              foreach($element as $key => $val) {
               $keys[]= "{$key}";
                }
              }
            $header = array_unique($keys); // elimina los repetidos
        
            return $header;         
}
}
