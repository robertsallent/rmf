<?php
/*
 FICHERO: controller/Controller.php
 CLASE: Controller (abstracta)
 
 Clase base de la que heredan todos los controladores.
 
 Dependencias: ---
 Autor: Robert Sallent
 Última revisión: 04/04/2019
 */

abstract class Controller{
    
    protected $usuario=NULL;    //usuario identificado en la aplicación
    protected $admin=false;     //si el usuario identificado es admin o no
    
    //campos que llegan via $_GET, $_POST y $_COOKIE
    protected $get=[];
    protected $post=[];
    protected $cookie=[];
    
    //array de datos que se pasará a las vistas
    protected $data=[];
    
    //CAMPOS HABITUALES para pasar a las vistas:
    //'index': asegura que no se carga una vista sin acceder mediante index.php
    //'usuario': usuario identificado en la aplicación
    //'mensaje': mensaje que se quiere mostrar en la vista
    //se pueden añadir otros campos que se necesiten

    
    //constructor (inicializa las propiedades)
    public function __construct(){
        $this->usuario=Login::getUsuario(); //recupera el usuario
        $this->admin=Login::isAdmin(); //recupera si el usuario es admin o no
        
        //mapea los datos que llegan por $_GET, $_POST y $_COOKIE
        foreach($_GET as $campo=>$valor)
            $this->get[$campo]=DB::escape($valor);
        
        foreach($_POST as $campo=>$valor)
            $this->post[$campo]=DB::escape($valor);
        
        foreach($_COOKIE as $campo=>$valor)
            $this->cookie[$campo]=DB::escape($valor);
    
        //añade los datos que siempre se pasan a las vistas al array de datos
        $this->data['index']=true;
        $this->data['usuario']=$this->usuario; 
        $this->data['admin']=$this->admin;
    }
}