<?php
/*
 FICHERO: app/controllers/Usuario.php
 CLASE: Usuario
 HEREDA DE: core/controllers/Controller

 Controlador que gestióna las operaciones con usuarios:
 registro, modificación de datos y baja


 Dependencias: 
 - app/config/Config.php
 - core/controllers/Controller.php 
 - core/helpers.php
 - app/model/UsuarioModel 
 - Y de las vistas en: app/views/usuarios
    
 Autor: Robert Sallent
 Última revisión: 04/04/2019
 */

class Usuario extends Controller{
    
    // PROPIEDADES HEREDADAS DE CONTROLLER:
    // data: array de datos para pasar a la vista
    // usuario: usuario que está identificado en la aplicación
    // admin: indica si el usuario está identificado y es admin o no
    // get: array de datos que llegan por GET
    // post: array de datos que llegan por POST
    // cookie: array de datos que llegan por COOKIE
    
    
    // METODOS
    
    // Método que se usa múltiples veces en esta clase para recuperar un usuario de la BDD
    // Retorna un UsuarioModel. En caso de que algo falle lanza excepciones.
    private function recuperar($id=0):UsuarioModel{
        // comprobar que llega el id del usuario que se quiere visualizar
        if(!$id) throw new Exception('No se ha indicado el id del usuario');
        
        // recuperar el usuario mediante el modelo
        $u=UsuarioModel::getById($id);
        
        // comprobar que el usuario existe
        if(!$u) throw new Exception('El usuario indicado no existe');
        
        return $u;
    }
    
    
    // PROCEDIMIENTO PARA VER EL PERFIL DE USUARIO (solo el propio usuario)
    public function perfil(){
        // comprobar que el usuario está identificado
        if(!$this->usuario) throw new Exception('Debes estar identificado para poder ver tu perfil');
          
        // carga la vista con el perfil del usuario
        load_view('usuarios/perfil', $this->data);
    }
    
    // PROCEDIMIENTO PARA VER EL PERFIL DE UN USUARIO (solo el administrador)
    public function perfiladmin($id=0){
        // comprobar que el usuario es admin
        if(!$this->admin) throw new Exception('Debes ser administrador');
                       
        // recuperar el usuario con el id indicado
        $this->data['u'] = $this->recuperar($id);
        
        // cargar la vista del perfil
        load_view('admin/usuarios/perfil', $this->data);
    }
    
    
    // PROCEDIMIENTO PARA LISTAR USUARIOS (solo el administrador)
    public function listar(){
        // comprobar que el usuario está identificado
        if(!$this->admin) throw new Exception('Debes ser administrador');
        
        // recupera todos los usuarios
        $this->data['usuarios']=UsuarioModel::get();    
            
        // carga la vista con la lista de usuarios
        load_view('usuarios/lista', $this->data);
    }
    
    
	// PROCEDIMIENTO PARA REGISTRAR UN USUARIO (cualquier usuario)
	// se realiza en dos pasos:
	// 1 - Mostrar el formulario de guardado (operación crear)
	// 2 - realizar el guardado (operación guardar)
	
    // paso1: muestra el formulario de nuevo usuario
	public function crear(){
	    // recupera el tamaño máximo para la foto de usuario desde el fichero de config
		$this->data['max_image_size'] = Config::get('user_image_max_size');
		
		// carga la vista con el formulario
		load_view('usuarios/registro', $this->data);
	}
	
	
	// paso 2: guarda los datos del usuario en la BDD 
	public function guardar(){
	    // asegura que llegue el formulario
	    if(!empty($_POST['guardar'])){
			// crear una instancia de UsuarioModel
			$nuevoUsuario = new UsuarioModel();
			
			// toma los datos que vienen por POST y los mapea al UsuarioModel
			$nuevoUsuario->user = $this->post['user'];
			$nuevoUsuario->password = MD5($this->post['password']);
			$nuevoUsuario->nombre = $this->post['nombre'];
			$nuevoUsuario->email = $this->post['email'];
					
			// PARA LA IMAGEN DE PERFIL
			// si nos han enviado una imagen, hay que recuperarla
			if($_FILES['imagen']['error']!=4){
				// el directorio y el tamaño máximo se configuran en el fichero config.php
				$dir = Config::get('user_image_directory');
				$tam = Config::get('user_image_max_size');
				
				// realiza la subida de la imagen usando la clase Upload
				$nuevoUsuario->imagen = Upload::saveImage($_FILES['imagen'], $dir, $tam);
			}
							
			// intenta guardar el usuario en BDD
			if(!$nuevoUsuario->guardar())
				throw new Exception("No se pudo registrar el usuario.");
			
			// mostrar la vista de éxito si todo ha ido bien
			$this->data['mensaje'] = 'Operación de registro completada con éxito';
			load_view('exito', $this->data);
	    
	    }else{
	        // si no llegaron datos en el formulario, redirigimos a la portada
	        redirect("/");
	    }
	}
		
	// PROCEDIMIENTO PARA MODIFICAR "MIS DATOS DE USUARIO" (solo el propio usuario)
	// se realiza en dos pasos:
	// 1 - Mostrar el formulario de modificación (operación editar)
	// 2 - realizar la actualización de datos (operación actualizar)
	
	// paso1: muestra el formulario de modificación de datos
	public function editar(){
		// comprobar que el usuario está identificado
		if(!$this->usuario)
			throw new Exception('Debes estar identificado para poder modificar tus datos');
			
		// recupera el tamaño máximo para la foto de usuario desde el fichero de config
		$this->data['max_image_size'] = Config::get('user_image_max_size');
		
		// carga la vista con el formulario
		load_view('usuarios/modificacion', $this->data);
	}
	
	
	// paso2: actualiza los datos del usuario en la BDD
	public function actualizar(){
	    
        // comprobar que el usuario está identificado
        if(!$this->usuario)
            throw new Exception('Debes estar identificado para poder modificar tus datos');
        
        // nos aseguramos de que lleguen los datos del formulario
        if(empty($this->post['modificar']))
            throw new Exception('No se recibieron datos');
        
        // comprueba que el usuario se valide correctamente
        if($this->usuario->password != MD5($this->post['password']))
            throw new Exception('El password no coincide, no se puede realizar la modificación de los datos.');
            
        // recupera el nuevo password (si se desea cambiar)
        if(!empty($this->post['newpassword']))
            $this->usuario->password = MD5($this->post['newpassword']);
                    
        // recupera el nuevo nombre y el nuevo email
        $this->usuario->nombre = $this->post['nombre'];
        $this->usuario->email = $this->post['email'];
        
        // TRATAMIENTO DE LA NUEVA IMAGEN DE PERFIL (si se intenta cambiar)
        $imagenModificada=false;
        
        if($_FILES['imagen']['error']!=4){
            // el directorio y el tam_maximo se configuran en el fichero config.php
            $dir = Config::get('user_image_directory');
            $tam = Config::get('user_image_max_size');
            
            // guarda la ruta de la imagen antigua en una variable para borrarla
            // del sistema de ficheros si todo ha funcionado correctamente
            $imagenAnterior = $this->usuario->imagen;
            
            // sube la nueva imagen
            $this->usuario->imagen = Upload::saveImage($_FILES['imagen'], $dir, $tam);
            $imagenModificada=true;
        }
                    
        // modificar el usuario en BDD
        if($this->usuario->actualizar()===false){
            // si no se pudo modificar hay que borrar la imagen que ya se subió
            if($imagenModificada)
                @unlink($this->usuario->imagen);
                
            // preparar los datos para la vista
            $this->data['failure'] = "No se pudieron modificar los datos.";
                
        }else{
            // borrado de la imagen antigua
            if(!empty($imagenAnterior))
                @unlink($imagenAnterior);
                
            // hace de nuevo "login" para actualizar los datos del usuario en la variable de sesión.
            Login::log_in($this->usuario->user, $this->usuario->password);
            $this->data['usuario'] = Login::getUsuario();
            
            // preparar los datos para la vista
                $this->data['success'] = "Modificación realizada correctamente.";
        }
        $this->data['max_image_size'] = Config::get('user_image_max_size');
        
        // cargar la vista de modificación con un mensaje de éxito
        load_view('usuarios/modificacion', $this->data);
	}
	
	
	
	// PROCEDIMIENTO PARA DAR DE BAJA UN USUARIO (solo el propio usuario)
	// se realiza en dos pasos:
	// 1 - Mostrar el formulario de baja (operación borrar)
	// 2 - realizar el borrado de la BDD (operación destruir)
	
	// paso 1: mostrar el formulario de baja
	public function borrar(){		
		// asegurarse que el usuario está identificado
	    if(!$this->usuario) throw new Exception('Debes estar identificado para poder darte de baja');
		
		// carga el formulario de confirmación
	    load_view('usuarios/baja', $this->data);
	}

	
	// paso 2: elimina el usuario de la BDD
	public function destruir(){
	    // asegurarse que el usuario está identificado
	    if(!$this->usuario) 
	        throw new Exception('Debes estar identificado para poder darte de baja');
	        
		// comprobar que nos llega la confirmación de la baja
		if(!empty($this->post['confirmar'])){	
		    
			// validar password
			if($this->usuario->password != MD5($this->post['password'])) 
				throw new Exception('El password no coincide, no se puede realizar la baja');
			
			// borrar el usuario actual de la base de datos
			if(!$this->usuario->borrar())
				throw new Exception('No se pudo dar de baja');
					
			// borra la imagen
			if(!empty($this->usuario->imagen)) 
			    @unlink($this->usuario->imagen); 
		
			// cierra la sesion
			Login::log_out();
			$this->data['usuario'] = NULL;
			
			// mostrar la vista de éxito
			$this->data['mensaje'] = "La baja del usuario se ha realizado correctamente.";
			load_view('exito', $this->data);
		
		}else{
		    // si no llegaron datos en el formulario, redirigimos a la portada
		    redirect("/");
		}
	}	
	
	
	// PROCEDIMIENTO PARA MODIFICAR LOS DATOS DE UN USUARIO (solo para el administrador)
	// se realiza en dos pasos:
	// 1 - Mostrar el formulario de modificación con los datos del usuario seleccionado (operación editaradmin)
	// 2 - realizar la actualización de datos (operación actualizaradmin)
	
	// paso1: muestra el formulario de modificación de datos
	public function editaradmin($id){
	    // comprobar que el usuario es admin
	    if(!$this->admin) throw new Exception('Debes ser administrador');
	        
	    // recupera el tamaño máximo para la foto de usuario desde el fichero de config
	    $this->data['max_image_size'] = Config::get('user_image_max_size');
	    
	    // recupera el usuario a partir del id
	    $this->data['u']=$this->recuperar($id);

	    // carga la vista con el formulario de modificación
	    load_view('admin/usuarios/modificacion', $this->data);
	}
	
	
	// paso2: actualiza los datos del usuario en la BDD
	public function actualizaradmin(){
	    
	    // comprobar que el usuario es admin
	    if(!$this->admin) throw new Exception('Debes ser admin');
	        
        // nos aseguramos de que lleguen los datos del formulario
        if(!empty($this->post['modificar']) && !empty($this->post['id'])){
            
            //recupera el id del usuario a modificar
            $id=$this->post['id'];
            
            //recupera el usuario desde el modelo
            $u=$this->recuperar($id);
                           
            // recupera los nuevos datos
            $u->nombre = $this->post['nombre'];
            $u->email = $this->post['email'];
            $u->privilegio = $this->post['privilegio'];
            $u->admin = empty($this->post['admin'])? 0 : 1;
            
            // TRATAMIENTO DE LA NUEVA IMAGEN DE PERFIL (si se intenta cambiar)
            if($_FILES['imagen']['error']!=4){
                // el directorio y el tam_maximo se configuran en el fichero config.php
                $dir = Config::get('user_image_directory');
                $tam = Config::get('user_image_max_size');
                
                // guarda la ruta de la imagen antigua en una variable para borrarla
                // del sistema de ficheros si todo ha funcionado correctamente
                $imagenAnterior = $u->imagen;
                
                // sube la nueva imagen
                $u->imagen = Upload::saveImage($_FILES['imagen'], $dir, $tam);
            }
            
            // modificar el usuario en BDD
            if($u->actualizar()===false){
                // si no se pudo modificar hay que borrar la imagen que ya se subió
                @unlink($u->imagen);
                throw new Exception("No se pudieron actualizar los datos del usuario.");
            }
            
            // borrado de la imagen antigua
            if(!empty($imagenAnterior))	@unlink($imagenAnterior);
                     
            // preparar los datos para la vista
            $this->data['success'] = "Modificación realizada correctamente.";
            $this->data['u'] = $u;
            $this->data['max_image_size'] = Config::get('user_image_max_size');
            
            // carga la misma vista, que mostrará el mensaje
            load_view('admin/usuarios/modificacion', $this->data);
                    
        }else{
            // si no llegaron datos en el formulario, redirigimos a la portada
            redirect("/");
        }
	}
	
	
	// PROCEDIMIENTO PARA ELIMINAR UN USUARIO (PARA EL ADMIN!)
	// se realiza en dos pasos:
	// 1 - Mostrar el formulario de eliminación (operación borraradmin)
	// 2 - realizar el borrado de la BDD (operación destruiradmin)
	
	// paso 1: muestra el formulario
	public function borraradmin(int $id=0){
	    // Comprobar que el usuario es admin
	    if(!$this->admin) throw new Exception('Debes ser administrador');
	     
	    // recupera el usuario a partir del id
	    $this->data['u']=$this->recuperar($id);
	    
        // muestra el formulario de confirmación
        load_view('admin/usuarios/confirmarborrado',$this->data);
	}
	
	// paso 2: elimina el usuario
	public function destruiradmin(){
	    //Comprobar que el usuario es admin
	    if(!$this->admin) throw new Exception('Debes ser administrador');
	        
        //comprobar que viene un ID por POST
        if(empty($this->post['id'])) throw new Exception('No se indicó el ID');
            
        // recupera el usuario a partir del id
        $u=$this->recuperar($this->post['id']);
            
        //eliminar el usuario
        if(!$u->borrar()) throw new Exception('No se pudo eliminar el usuario');
            
        //eliminar la foto del disco (si la hay)
        if($u->imagen) @unlink($u->imagen);
        
        //mostrar vista de éxito
        $this->data['mensaje']="usuario $u->user eliminado correctamente";
        load_view('exito',$this->data);
	}
	
	
	/* PARA LAS PETICIONES AJAX */
	
	
	// método usado en la operación de registro para comprobar el mail
	// mediante una petición AJAX
	public function checkmail(){
	    header('Content-Type: application/json');
	    
	    if(empty($this->post['email'])) die('{"ok":false}');
	   
	    // recuperar el mail que llega por POST
	    $email=$this->post['email'];
	    
	    // retorna JSON
	    echo UsuarioModel::emailOk($email)?'{"ok":true}':'{"ok":false}';
    
	}
	
	// método usado en la operación de registro para comprobar el usuario
	// mediante una petición AJAX
	public function checkuser(){
	    header('Content-Type: application/json');
	    
	    if(empty($this->post['user'])) die('{"ok":false}');
	    
	    // recuperar el user que llega por POST
	    $user=$this->post['user'];
	    
	    // retorna JSON
	    echo UsuarioModel::userOk($user)?'{"ok":true}':'{"ok":false}';
	    
	}
	
	
	
}

