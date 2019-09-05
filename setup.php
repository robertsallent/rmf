<?php 
/*
 FICHERO: setup.php
 
 Script que genera la tabla de usuarios.
 
 Este fichero debe ser eliminado del proyecto tras su correcta ejecución.
 Si todo va bien, se eliminará automáticamente.
 
 Dependencias: app/config/Config.php, core/autoload.php
 Autor: Robert Sallent
 Última revisión: 11/07/2019
 */

try{
    require_once 'app/config/Config.php'; //recupera la configuración
    require_once 'core/autoload.php'; //carga el autoload
       
    //Crea la tabla para los usuarios (el nombre de la tabla está en Config.php)
    $consulta="CREATE TABLE IF NOT EXISTS usuarios (
          id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,   
          user VARCHAR(32) NOT NULL UNIQUE KEY,
          password VARCHAR(32) NOT NULL,
          nombre VARCHAR(32) NOT NULL,
          apellido1 VARCHAR(32) NOT NULL DEFAULT '',
          apellido2 VARCHAR(32) NOT NULL DEFAULT '',
          privilegio INT(11) NOT NULL DEFAULT 0,
          admin BOOLEAN NOT NULL DEFAULT 0,
          email VARCHAR(128) NOT NULL UNIQUE KEY,
          imagen VARCHAR(512) NULL DEFAULT NULL,
          created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
          updated_at TIMESTAMP NULL DEFAULT NULL
        )ENGINE=InnoDB;";
    
    if(!DBPS::get()->query($consulta))
        throw new PDOException("No se pudo crear la tabla para los usuarios en la BDD");
    
    //Inserta el usuario administrador con password por defecto 1234 (habrá que cambiarlo)
    $consulta="INSERT INTO usuarios (user, password, nombre, privilegio, admin, email, imagen)
        VALUES ('admin', '81dc9bdb52d04dc20036dbd8313ed055', 'Administrador',
		1000, 1, 'admin@rmf', 'images/users/admin.png');";
    
    if(!DBPS::insert($consulta))
        throw new PDOException("No se pudo crear el usuario admin");

    //Redirección a la portada y eliminación de este script    
    header("Refresh:5; url=index.php"); //redirige a la portada
    echo "<p>La creación de la tabla de usuarios se realizó correctamente.</p>";
    echo "<p>Redirigiendo a la portada en 5 segundos...</p>";
    @unlink('setup.php'); //Borrado de este fichero
    
}catch(Throwable $t){
    die("Se produjo el siguiente error al cargar el framework: ".$t->getMessage());
}