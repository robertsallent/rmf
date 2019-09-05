<?php
/*
 FICHERO: core/App.php
 CLASE: App
 
 Sus tareas son:
  - iniciar la sesión
  - comprobar si se está haciendo login-logout
  - invocar al dispatcher
  - gestionar los errores mediante excepciones, cargando la vista de error.
 
 Dependencias: 
 - core/libraries/Login.php
 - core/Dispatcher.php

 Autor: Robert Sallent
 Última revisión: 25/03/2019
 */

class App{
	public static function start(){
	    
	    try{	
	        session_start();         //inicia o reanuda la sesión
			Login::comprobar();      //gestiona la identificación de usuarios		
			Dispatcher::dispatch();  //invoca al gestor de peticiones
	   		
		//si se ha producido algún error...
    	}catch(Throwable $e){
    	    //preparar los datos para la vista
    	    $data=[];
    	    $data['index']=true;
    	    $data['usuario']=Login::getUsuario();
    	    $data['mensaje']=$e->getMessage();
    	
    	    //cargar la vista, pasándole los datos que debe mostrar
    	    load_view('error', $data);
    	}
	}
}