<?php
/*
 FICHERO: core/helpers.php
 
 Funciones globales, útiles para diversas tareas.
 
 Dependencias: app/config/Config.php
 Autor: Robert Sallent
 Última revisión: 10/09/2019
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
    
    // prepara la ruta del fichero donde se debe encontrar la vista
    $ruta="app/views/$vista.php";
    
    //si no se encuentra el fichero...
    if(!is_readable($ruta))
        throw new Exception("No se encontró la vista $vista.");
        
    //mapear los datos del array de datos en variables independientes
    foreach($datos as $clave=>$valor)
        $$clave = $valor;
        
    require($ruta); //carga la vista
}