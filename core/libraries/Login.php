<?php 
/*
 FICHERO: core/libraries/Login.php
 CLASE: Login

 Clase que realiza las operaciones de login/logout y el volcado y recuperación
 de los datos del usuario mediante variables de sesión.

 Dependencias:
 - app/config/Config.php
 - app/model/Usuario.php
 - core/helpers.php
 - core/libraries/DB.php

 Autor: Robert Sallent
 Última revisión: 01/04/2019
 */

class Login{
	// PROPIEDADES

	// Propiedad estática que contiene el usuario identificado 
	// actualmente en la aplicación
	private static $usuario = NULL;

	
	// METODOS (que recuperan información)
	
	// Devuelve el usuario identificado en la aplicación.
	// Devuelve NULL si no hay ningún usuario identificado.
	public static function getUsuario():?Usuario{
		return self::$usuario;
	}
	
	// Devuelve el nivel de privilegio del usuario identificado.
	// Devuelve 0 si no hay ningún usuario identificado.
	public static function privilegio():int{
	    return self::$usuario? self::$usuario->privilegio : 0;
	}
	
	// Devuelve true si el usuario cumple el nivel de privilegio indicado, false en caso contrario
	public static function isAllowed(int $minLevel=0):bool{
	    return self::$usuario && self::$usuario->privilegio>=$minLevel;
	}
	
	// Devuelve si hay usuario identificado y éste es además administrador	
	public static function isAdmin():bool{
		return self::$usuario && self::$usuario->admin;
	}
	
	
	// METODOS (que realizan operaciones)
	
	// Realiza la operación de LOGIN
	public static function log_in($u, $p){	
		// comprueba que el usuario y password sean correctos
		if(!Usuario::validar($u, $p))
			throw new Exception('Error en la identificacion');
	
		// recupera el usuario y lo guarda en la variable de sesión
		$_SESSION['user'] = serialize(Usuario::getUsuario($u));					
	}
	
	// Realiza la operación de LOGOUT
	// (se usa cuando se hace logout o se da de baja el usuario activo)
	public static function log_out(){
		session_unset(); 	    // vacía el array $_SESSION
		session_destroy(); 	    // destruye la sesión
		self::$usuario = null;  // olvida el usuario identificado
		
		// elimina la cookie de sesión (opcional, descomentar)
		// $p = session_get_cookie_params();
		// setcookie(session_name(),'',time()-1000,$p['path'],$p['domain'],$p['secure'],$p['httponly']);
		
		// REDIRECCIONAR tras el logout con lo que indique el fichero Config
		if(Config::get('logout_redirect')){
		    $u = Config::get('logout_redirect_url');
		    $t = Config::get('logout_redirect_delay');
		    
		    redirect($u, $t); // realiza la redirección
		    die(Config::get('logout_redirect_message'));
		}
	}
	
	
	// Método que gestiona las operaciones de login-logout  y almacena en la variable 
	// estática $usuario el usuario actual.
	// ES USADO POR LA CLASE APP
	public static function comprobar(){
			
		//si piden hacer login:
		if(!empty($_POST['login'])){
			//recuperar los datos que llegan por POST
			$u = DB::escape($_POST['user']); //nombre de usuario
			$p = MD5(DB::escape($_POST['password'])); //password
	
			self::log_in($u,$p); //llamada al método que realiza login
		}
			
		//si piden hacer logout
		if(!empty($_POST['logout']))
			self::log_out(); //llamada al método que realiza logout
			
		//Pase lo que pase, recuperamos la información contenida en la variable de sesión
		//para guardarla en la propiedad estática $usuario.
		self::$usuario = empty($_SESSION['user'])? null : unserialize($_SESSION['user']);
	}
}