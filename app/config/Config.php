<?php
/*
 FICHERO: app/config/Config.php
 CLASE: Config
 
 Configuración general de la aplicación.
 Se deben configurar aquí todos los parámetros que queramos ajustar.
 
 Los parámetros se encuentran documentados.
 
 Dependencias: ---
 Autor: Robert Sallent
 Última revisión: 01/04/2019
 */

class Config{ 	
    // CONFIGURACIÓN GENERAL
    private $app_name='RMF - RobS Micro Framework'; // nombre de la aplicación
    private $company_name='Desarrollo de aplicaciones web'; // cliente
	
	// Ruta donde se encuentre el proyecto, relativa al DOCUMENTROOT
	private $url_base = '/';  // Ejemplo: '/miaplicacion/project/';
	
	// ENTORNO (development | production)
	// algunos mensajes de error solamente aparecerán en development
	private $environment='development';
	
	private $locale='es'; // localización de idioma
	
	// CONFIGURACIÓN DE LA BASE DE DATOS
	private $sgdb = 'mysql';            // driver usado por PDO para la conexión
	private $db_host = 'localhost'; 	// host donde se encuentra la BDD (normalmente localhost)
	private $db_user = 'root';			// usuario
	private $db_pass = '';			    // password
	private $db_name = 'rmf';		    // nombre de la BDD a utilizar
	private $db_charset = 'utf8';	    //codificación de caracteres

	// CONTROLADOR Y OPERACION POR DEFECTO
	private $default_controller = 'Welcome'; // controlador por defecto
	private $default_method = 'index';		// método por defecto
	
	// DIRECTORIOS POR DEFECTO PARA EL MVC
	// son los directorios en los que el autoload buscará las clases
	private $model_directory='app/model';
	private $view_directory='app/views/';
	private $controller_directory='app/controllers/';
	private $template_directory='app/templates/';
	
	private $library_directory='core/libraries/';
	private $errors_directory='core/exceptions/';
	
	// DIRECTORIOS AUTOLOAD
	// rutas adicionales donde el autoload debe buscar las clases que necesite
	private $autoload_directories=[];
	
	// REDIRECCION DE LOGOUT
	private $logout_redirect=true;
	private $logout_redirect_url='/';
	private $logout_redirect_delay=1; // retardo para llevarte a la portada (0=inmediato)
	private $logout_redirect_message="Volviendo a la portada...";
		
	// OPCIONES PARA LAS IMAGENES GENERICAS
	private $image_not_found = 'images/no_image.png'; // sin imagen
	
	// OPCIONES PARA LAS IMAGENES DE USUARIO
	private $user_image_directory = 'images/users/';	// directorio para las imágenes de usuario
	private $default_user_image = 'images/users/user.png'; // imagen por defecto para usuarios
	private $user_image_max_size = 1024000; // tamaño máx imágenes de usuario
	

	
	// -----------------------------------------------------------------------------
	// NO CAMBIAR A PARTIR DE ESTE PUNTO
	private static $config = null;
	
	// método público para recuperar la configuración o una propiedad de la configuración
	public static function get($property=''){
		if(empty(self::$config)) 
		    self::$config = new self();
		
		return empty($property)? self::$config : (self::$config)->$property;
	}	
	
	// getter para las propiedades
	public function __get($name){
	    return $this->$name;
	}		
}	
