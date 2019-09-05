<?php
/* 
FICHERO: autoload/autoload.php

Gestiona la carga de clases de forma automatizada (autoload).
Los directorios donde hay que buscar las clases se deben indicar
en el fichero Config.php.

Dependencias: config/Config.php
Autor: Robert Sallent
Última revisión: 08/11/2018
*/

//función para cargar las clases requeridas
function load($clase){
   //carpetas donde buscar las clases a cargar
   $carpetas=[
       Config::get()->controller_directory, 
       Config::get()->model_directory,
       Config::get()->library_directory,
       Config::get()->template_directory,
       Config::get()->errors_directory
   ];
   
   //añade a la lista de carpetas las adicionales indicadas en el fichero de config
   $carpetas+=Config::get()->autoload_directories;
 
   //busca las clases por las carpetas
   foreach($carpetas as $carpeta){      
        $ruta="$carpeta/$clase.php";
        
        if(file_exists($ruta)){
            require $ruta;
            return true; //ahorra iteraciones
        }
    }
    
    //si no puede cargar una clase, se detiene el proceso
    $mensaje=Config::get()->environment=='development'?
        "No se encontro el fichero $ruta, revisa el listado de carpetas en autoload_directories del fichero Config.php." :
        "Error al cargar $ruta, contacta con el desarrollador";
    die($mensaje);
}

//Registra el autoloader
spl_autoload_register("load");  //registrar los autoloaders

