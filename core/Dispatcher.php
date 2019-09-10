<?php
/*
 FICHERO: core/Dispatcher.php
 CLASE: Dispatcher
 
 Se encarga de enviar la petición al controlador y método adecuado.
 Actúa como un FrontController
 
 FORMATO DE LAS PETICIONES:
 index.php?controlador=Usuario&operacion=registro
 index.php?controlador=Telefono&operacion=ver&parametro=14
 
 Como se usan URLS AMIGABLES, será equivalente hacer:
 /usuario/registro
 /telefono/ver/14
 
  Autor: Robert Sallent
 Última revisión: 10/09/2019
 */

class Dispatcher{
    
    public static function dispatch(){        
        //recupera el controlador a partir de la petición
        $controlador = empty($_GET['controlador'])? 
            Config::get('default_controller'):
            ucwords($_GET['controlador']).'Controller';
                 
        //recupera la operación que se desea realizar
        $operacion = empty($_GET['operacion'])? 
            Config::get('default_method'):
            $_GET['operacion'];
        
        //si no se puede invocar la operación, ERROR
        if(!is_callable(array($controlador, $operacion)))
            throw new Exception("no existe la operación $controlador $operacion");
            
        //recuperar el parámetro que viene por GET
        $parametro = empty($_GET['parametro'])? '':$_GET['parametro'];
        
        //si va todo bien, creamos el objeto controlador y ejecutamos la operación
        (new $controlador())->$operacion($parametro);
    }
}