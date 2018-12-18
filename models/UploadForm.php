<?php

namespace app\models;
use yii\base\Model;

/**
* UploadForm es el modelo que controla como cargar archivos.
*/
class UploadForm extends Model
{

public $file;
public $file2;

/**
 * @return arreglo de reglas.
 */
public function rules()
{
    /*
     * checkExtensionByMimeType=>false permite reconocer archivos csv para la carga
     * solo para el scenario csvfile
     */
    return [
        [['file'], 'file', 'skipOnEmpty' => false,'extensions' => 'xml','on'=>'xmlfile'], // escenario para el segundo ejercicio
        [['file'], 'file', 'skipOnEmpty' => false,'extensions' => ['xls', 'csv'], 'checkExtensionByMimeType'=>false,'on'=>'csvfile'], // escenario para el tercer ejercicio
        [['file2'], 'file', 'skipOnEmpty' => false,'extensions' => ['xls', 'csv'], 'checkExtensionByMimeType'=>false,'on'=>'csvfile'], // escenario para el tercer ejercicio

    ];
}

/**
 * @return arreglo de etiquetas.
 */
public function attributeLabels()
    {
        return [
            'file' => 'Archivo',
            'file2' => 'Archivo 2',
        ];
    }

}

  

