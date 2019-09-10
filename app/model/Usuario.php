<?php
/*
 FICHERO: app/controllers/Usuario.php
 CLASE: Usuario
  
 Modelo para gestionar los usuarios
  
 Dependencias:
 - app/config/Config.php
 - core/libraries/DB.php
 - core/libraries/DBPS.php
 
 Autor: Robert Sallent
 Última revisión: 11/07/2019
 */

class Usuario{
    	
	//PROPIEDADES
  	public $id=0;          // identificador interno del usuario
	public $user='';       // nombre de usuario
	public $password='';   // clave, codificada en MD5
	public $nombre='';     // nombre del usuario
	public $fecha=NULL;    // fecha de alta
	public $email='';      // email
	public $imagen=NULL;   // imagen de perfil
	public $privilegio=100;  // nivel de privilegio
	public $admin=0;       // si es administrador o no

	// METODOS
	
	// Este método recupera todos los usuarios que hay en la BDD. 
	// Retorna un array de Usuario
	public static function get():array{
	    $consulta = "SELECT * FROM usuarios";
	    return DBPS::selectAll($consulta, 'Usuario');
	}
	
	// Este método recupera un usuario de la BDD a partir del nombre de usuario
	// Retorna NULL si el usuario no existe
	public static function getUsuario($u):?Usuario{
	    $consulta = "SELECT * FROM usuarios WHERE user=?;";
	    return DBPS::select($consulta, 'Usuario', [$u]);
	}
	
	// Este método recupera un usuario de la BDD a partir del identificador único
	// Retorna NULL si el usuario no existe
	public static function getById($id=0):?Usuario{
	    $consulta = "SELECT * FROM usuarios WHERE id=?;";
	    return DBPS::select($consulta,'Usuario',[$id]);
	}
	
	// Este método recupera el número total de usuarios registrados
	// Es útil para las estadísticas del panel de control del admin
	public static function total():int{
	    return DBPS::total('usuarios');
	}
	
	// Guarda el usuario en la BDD
	public function guardar(){
	    if($this->imagen){
            $consulta = "INSERT INTO usuarios(user, password, nombre, privilegio, admin, email, imagen)
    		 VALUES (?,?,?,?,?,?,?)";
	        return DBPS::insert($consulta,[$this->user,$this->password,$this->nombre,100,0,$this->email,$this->imagen]);
	    }else{
	        $consulta = "INSERT INTO usuarios(user, password, nombre, privilegio, admin, email)
    		 VALUES (?,?,?,?,?,?)";
	        return DBPS::insert($consulta,[$this->user,$this->password,$this->nombre,100,0,$this->email]);
	    }		
	}
		
	// Actualiza los datos del usuario en la BDD
	public function actualizar(){
	    if($this->imagen){
	        $consulta = "UPDATE usuarios SET user=?, password=?, 
                         nombre=?, privilegio=?, admin=?, email=?, imagen=? WHERE id=?";
	        return DBPS::update($consulta,[$this->user,$this->password,
	                     $this->nombre,$this->privilegio,$this->admin,$this->email,$this->imagen,$this->id]);
	    }else{
	        $consulta = "UPDATE usuarios SET user=?, password=?,
                         nombre=?, privilegio=?, admin=?, email=? WHERE id=?";
	        return DBPS::update($consulta,[$this->user,$this->password,
	                     $this->nombre,$this->privilegio,$this->admin,$this->email,$this->id]);
	    }		
	}
		
	// Elimina el usuario de la BDD
	public function borrar(){
		$consulta = "DELETE FROM usuarios WHERE id=?;";
		return DBPS::delete($consulta,[$this->id]);
	}
	
	// Este método sirve para validar usuario y su password
	// Se usa en la operación de LOGIN
	public static function validar($u, $p){
	    $consulta = "SELECT * FROM usuarios WHERE user=? AND password=?;";
		return DBPS::select($consulta, self::class, [$u,$p]);
	}	
	
	// Este método retorna si un email existe ya o no
	public static function emailOk(string $email):bool{
	    $consulta="SELECT * FROM usuarios WHERE email=?";
	    return DBPS::select($consulta,'stdClass',[$email])? false : true;
	}
	
	// Este método retorna si un usuario existe ya o no
	public static function userOk(string $user):bool{
	    $consulta="SELECT * FROM usuarios WHERE user=?";
	    return DBPS::select($consulta,'stdClass',[$user])? false : true;
	}	
}