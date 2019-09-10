<?php 
/*
 FICHERO: index.php
 
 CARGA EL FRAMEWORK
 Y después inicia la aplicación con App::start()
  
 Autor: Robert Sallent
 Última revisión: 25/03/2019
 */

try{  
    // Carga del autoload
    require __DIR__ .'/vendor/autoload.php';
    
    // Carga de funciones globales (helpers)
    require_once __DIR__ .'/core/helpers.php'; 
    
    // Arranca la aplicación
    App::start(); 

// Si se produce algún error en la carga del framework...
}catch(Throwable $e){
    die("Se produjo el siguiente error al cargar el framework: ".$e->getMessage());
}