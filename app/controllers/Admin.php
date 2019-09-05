<?php
/*
 FICHERO: app/controllers/Admin.php
 CLASE: Admin
 HEREDA DE: core/controllers/Controller
 
 Controlador para las operaciones del administrador.
 
 Los métodos aquí descritos son operaciones que solamente puede realizar el usuario admin y que no 
 podrían estar ubicadas en ningún otro controlador. 
  
 Dependencias:
 - core/controllers/Controller.php
 - core/helpers.php
 - La vista: app/views/admin/panel.php
 
 Autor: Robert Sallent
 Última revisión: 03/04/2019
 */

class Admin extends Controller{
	
	// Para mostrar el panel de control
	public function index(){
	    //comprobar que el usuario es admin
	    if(!Login::isAdmin())
	        throw new Exception('Debes ser administrador');
	    
	    //recuperar información para las estadísticas del panel de control
	    $this->data['registrados']=UsuarioModel::total();
	    
		//cargar la vista
		load_view('admin/panel', $this->data);
	}
}