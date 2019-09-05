<?php
/*
 FICHERO: core/helpers.php
 
 Funciones globales, útiles para diversas tareas.
 
 Dependencias: app/config/Config.php
 Autor: Robert Sallent
 Última revisión: 01/04/2019
 */


//REDIRECCION A OTRA URL
function redirect(string $url, int $time=0){
    header("Refresh:$time; url=$url");
}

//CARGA DE FICHEROS
function load_file(string $ruta){
    if(!is_readable($ruta)) 
        throw new Exception("No se puede cargar $ruta.");
    else
        require_once($ruta);
}

//CARGA DE VISTAS
function load_view(string $vista, array $datos=[]){
    
    $ruta=Config::get('view_directory').$vista.'.php';
    
    //si no se encuentra el fichero con la vista...
    if(!is_readable($ruta))
        throw new Exception("No se encontró la vista $vista.");
        
    //mapear los datos del array de datos en variables independientes
    foreach($datos as $clave=>$valor)
        $$clave = $valor;
        
    require($ruta); //carga la vista
}