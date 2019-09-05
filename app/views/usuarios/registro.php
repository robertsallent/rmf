<!DOCTYPE html>
<?php 
    // comprueba que se haya accedido desde un controlador
    if(empty($index)) 
        die('no se puede acceder directamente a una vista.');
?>

<html lang="<?=Config::get('locale')?>">
    <head>
    	<!-- URL BASE -->
    	<base href="<?=Config::get('url_base')?>">
    	
    	<!-- ETIQUETAS META -->
    	<meta charset="UTF-8">
    	<meta name="description" content="Registro de usuarios">
    	<meta name="keywords" content="registro, usuario">
    	<meta name="author" content="Robert Sallent">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    			
    	<!-- TITULO DE LA PÁGINA Y FAVICON -->
    	<title><?=Config::get('app_name')?> - Registro de usuarios</title>
    	<link rel="shortcut icon" href="images/logos/rmf_mini.png" type="image/png">
    	
    	<!-- FICHEROS CSS  -->
    	<link rel="stylesheet" type="text/css" href="css/estilo.css">
    	<link media="screen and (max-width: 800px)" rel="stylesheet" type="text/css" href="css/tablet.css">
    	<link media="screen and (max-width: 500px)" rel="stylesheet" type="text/css" href="css/telefono.css">
    </head>
	<body>
		<?php 
			Template::header(); //pone el header
    		Template::loginForms($usuario); //pone el formulario de login/logout
			Template::menu($usuario); //pone el menú
		?>
		
		<main>
			<h2>Formulario de registro</h2>
			
			<p>
				<img src="images/samples/info.png" class="icono" alt="informacion">
				Rellena todos los campos para completar el proceso de registro.
			</p>
			
			<!-- FORMULARIO DE REGISTRO -->
			<form class="formulario" method="post" action="Usuario/guardar" enctype="multipart/form-data" autocomplete="off">
				<label>User:</label>
				<input type="text" name="user" required="required" pattern="^[a-zA-Z]\w{2,9}" title="3 a 10 caracteres (numeros, letras o guión bajo), comenzando por letra">
				<br>
				
				<label>Password:</label>
				<input type="password" name="password" required="required" pattern=".{4,16}" title="4 a 16 caracteres">
				<br>
				
				<label>Nombre:</label>
				<input type="text" name="nombre" required="required">
				<br>
				
				<label>Email:</label>
				<input type="email" name="email" required="required">
				<br>
				
				<label>Imagen:</label>
				<input type="hidden" name="MAX_FILE_SIZE" value="<?=$max_image_size;?>">		
				<input type="file" accept="image/*" name="imagen">
				<span>max <?=intval($max_image_size/1024);?>KB</span>
				<br>
				
				<label></label>
				<input class="button" type="submit" name="guardar" value="Registrar">
				<br>
			</form>
		</main>
		
		<div class="links">
			<a id="back" onclick="history.back();">Atrás</a>
			<a href="">Inicio</a>
		</div>
		
		<?php 
		  Template::footer();
		?>
    </body>
</html>