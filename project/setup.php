<?php 
/*
 FICHERO: setup.php
 
 Script que genera la tabla de usuarios.
 
 Este fichero debe ser eliminado del proyecto tras su correcta ejecución.
 Si todo va bien, se eliminará automáticamente.
 
 Dependencias: app/config/Config.php, core/autoload.php
 Autor: Robert Sallent
 Última revisión: 20/01/2020
 */

try{
    // Carga del autoload
    require __DIR__ .'/vendor/autoload.php';
    
    //Crea la tabla para los usuarios
    $consulta="CREATE TABLE usuarios (
      id INT(11) NOT NULL PRIMARY KEY,
      user VARCHAR(32) NOT NULL UNIQUE KEY,
      password VARCHAR(32) NOT NULL,
      nombre VARCHAR(128) NOT NULL,
      privilegio INT(11) NOT NULL DEFAULT 0,
      admin INT(11) NOT NULL DEFAULT 0 COMMENT '0 no admin, 1 admin', 
      email VARCHAR(128) NOT NULL UNIQUE KEY,
      imagen VARCHAR(512) NULL DEFAULT NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if(!DBPS::get()->query($consulta))
        throw new PDOException("No se pudo crear la tabla para los usuarios en la BDD");
    
    //Inserta el usuario administrador con password por defecto 1234 (habrá que cambiarlo)
    $consulta="INSERT INTO usuarios (id, user, password, nombre, privilegio, admin, email, imagen) VALUES
      (1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'Administrador', 1000, 1, 'admin@rmf.cat', 'images/users/admin.png'),
      (2, 'supervisor', '81dc9bdb52d04dc20036dbd8313ed055', 'Supervisor', 500, 0, 'svsr@rmf.cat', 'images/users/supervisor.png'),
      (3, 'user', '81dc9bdb52d04dc20036dbd8313ed055', 'User', 0, 0, 'user@rmf.cat', NULL);";
    
    if(!DBPS::insert($consulta))
        throw new PDOException("No se pudo crear el usuario admin");

    //Redirección a la portada   
    header("Refresh:5; url=index.php"); //redirige a la portada
    
    //Mensaje de confirmación
    echo "<p>La creación de la tabla de usuarios se realizó correctamente.</p>";
    echo "<p>Redirigiendo a la portada en 5 segundos...</p>";
    
    //Eliminación de este script
    @unlink('setup.php'); //Borrado de este fichero
    
}catch(Throwable $t){
    die("Se produjo el siguiente error: ".$t->getMessage());
}