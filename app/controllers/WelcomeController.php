<?php
/*
 FICHERO: app/controllers/Welcome.php
 CLASE: Welcome
 HEREDA DE: core/controllers/Controller
 
 Controlador por defecto, invocado por el dispatcher en caso de que
 en la petición no se indique controlador.
 
 
 Dependencias:
 - core/controllers/Controller.php
 - core/helpers.php
 - La vista: app/views/portada
 
 Autor: Robert Sallent
 Última revisión: 01/04/2019
 */

class WelcomeController extends Controller{
	
	//Método por defecto
	//Carga la portada del sitio (vista welcome_message)
	public function index(){
		//cargar la vista
		load_view('portada', $this->data);
	}		
}
