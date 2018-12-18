# qashoptest
_Este proyecto es una prueba técnica para Tech Lead, hecho en Yii2 . Las funciones principales son pasar un archivo de xml a csv y fusionar 2 archivos csv_

[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](https://www.yiiframework.com/) 
[![License](https://img.shields.io/badge/license-BSD3-orange.svg)](https://github.com/jiuly256/qashoptest/blob/master/README.md)
[![Autor](https://img.shields.io/badge/creado%20por-Jiuly%20Rojas-ff69b4.svg)](https://jiuly.com.ve/blog/)

## Comenzando 🚀

_La prueba consistirá en 3 problemas:_
_● Cada problema deberá ser resuelto en una clase distinta._
_● Se puede usar composer para instalar cualquier componente o librería que se cree
necesario._
_● Se pueden crear clases auxiliares para estructurar mejor el código_

_Prueba 1: Refactoring
Tenemos la clase Product (Anexo 1) con un método llamado stock(). El código de dicho método
realiza comprobaciones duplicadas y el código carece de bastante legibilidad. Refactoriza el
método (creando métodos auxiliares, reordenando el código, renombrando variables, etc) para
que se entienda mejor qué hace y sea más legible. Lo único que no se puede cambiar es la
firma del método._


```
  qashops
         model
              qashops-anexo_1.php
   

```

_Prueba 2: Aplanamiento XML
Crear un metodo, que dado un path a un fichero XML, lo aplane y guarde en un csv..
Ejemplo de XML:_
```
<? xml version ="1.0" encoding ="UTF-8" ?>
< xml >
< products >
< product >
< name_header > name </ name_header >
< description_header > description </ description_header >
< image_1_header > image_1 </ image_1_header >
< colour_header > colour </ colour_header >
< size_header > size </ size_header >
< sleeve_length_header > sleeve_length </ sleeve_length_header >
</ product >
< product >
< name_header > name </ name_header >
< description_header > description </ description_header >
< sku_header > sku </ sku_header >
< image_1_header > image_1 </ image_1_header >
< colour_header > colour </ colour_header >
< heel_height_header > heel_height </ heel_height_header >
< laces_header > laces </ laces_header >
</ product >
< product >
< name_header > name </ name_header >
< description_header > description </ description_header >
< sku_header > sku </ sku_header >
< image_1_header > image_1 </ image_1_header >
< colour_header > colour </ colour_header >
< size_header > size </ size_header >
< sleeve_length_header > sleeve_length </ sleeve_length_header >
</ product >
< product >
< name_header > name </ name_header >
< description_header > description </ description_header >
< sku_header > sku </ sku_header >
< image_1_header > image_1 </ image_1_header >
< colour_header > colour </ colour_header >
< size_header > size </ size_header >
< sleeve_length_header > sleeve_length </ sleeve_length_header >
</ product >
</ products >
</ xml >
```
_Output Esperado:_
```
name_header;description_header;image_1_header;colour_header;size_header;sleeve_length_
header;sku_header;heel_height_header;laces_header
name;description;image_1;colour;size;sleeve_length;;;
name;description;image_1;colour;;;sku;heel_height;laces
name;description;image_1;colour;size;sleeve_length;sku;;
name;description;image_1;colour;size;sleeve_length;sku;;
```
_Prueba 3: Merge de dos ficheros CSV
Crear un método, que dado 2 paths de dos ficheros csv, los unifique en un solo fichero. Las
cabeceras (asumimos que la cabecera está siempre en la primera fila) que estén en común en
ambos ficheros deben estar unificadas y solo estar presentes una vez en el fichero devuelto._

_Ejemplo Fichero 1:_
```
Header_1,Header_2,Header_3,Header_4
1,2,3,4
4,5,6,7
```

_Ejemplo Fichero 2:_
```
Header_5,Header_2,Header_6,Header_7
8,9,10,11
12,13,14,15
```

_Output Esperado:_
```
Header_1,Header_2,Header_3,Header_4,Header_5,Header_6,Header_7
1,2,3,4,,,
4,5,6,7,,,
,9,,,8,10,11
,13,,,12,14,15
```

_Los archivos de prueba estan en una carpeta en la raiz llamada_ ***archivos de prueba***

### Instalación 🔧

_Correr en la carpeta raiz del proyecto_

```
composer update

```

## Construido con 🛠️

_yii framework y php_

* [Yii](https://www.yiiframework.com/) - El framework web usado


## Autores ✒️


***Jiuly Alexandra Rojas** - *Trabajo Inicial* - [jiuly256](https://github.com/jiuly256)

## Licencia 📄

Este proyecto está bajo la Licencia (Licencia MIT) - mira el archivo [LICENSE](https://github.com/jiuly256/qashoptest/blob/master/LICENSE)(LICENSE.md) para detalles

## Gracias 🎁
