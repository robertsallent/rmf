<?php 
/*
 FICHERO: index.php
 
 CARGA EL FRAMEWORK
 Y después inicia la aplicación con App::start()
 
 Dependencias: 
 - app/config/Config.php
 - core/helpers.php
 - core/autoload.php
 - core/App.php
 - core/Dispatcher.php
 - core/controllers/Controller.php
 
 
 Autor: Robert Sallent
 Última revisión: 25/03/2019
 */

try{  
    // Carga del autoload
    require __DIR__ .'/vendor/autoload.php';
    
    //Carga la configuración
   // require_once __DIR__ .'/app/config/Config.php'; //recupera la configuración
    
    //Carga el núcleo del framework....
    require_once __DIR__ .'/core/helpers.php';    //carga las funciones helper
    //require_once __DIR__ .'/core/autoload.php';   //carga el autoload
    //require_once __DIR__ .'/core/App.php';        //carga la clase App
    //require_once __DIR__ .'/core/Dispatcher.php'; //carga el repartidor de peticiones
    //require_once __DIR__ .'/core/controllers/Controller.php';  //carga la clase base para los controladores
    
    
    
    App::start(); //arranca la aplicación

//Si se produce algún error en la carga del framework...
}catch(Throwable $e){
    die("Se produjo el siguiente error al cargar el framework: ".$e->getMessage());
}