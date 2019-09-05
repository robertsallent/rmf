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
    	<meta name="description" content="Baja de usuario">
    	<meta name="keywords" content="baja">
    	<meta name="author" content="Robert Sallent">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    			
    	<!-- TITULO DE LA PÁGINA Y FAVICON -->
    	<title><?=Config::get('app_name')?> - Baja de usuario</title>
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
			<h2>Formulario de baja de usuario</h2>
			<p>
				<img src="images/samples/info.png" class="icono" alt="informacion">
				Por favor, confirma tu solicitud de baja introduciendo el password asociado a tu cuenta.
			</p>
		
			<!-- FORMULARIO DE BAJA DE USUARIO -->
			<form class="formulario" method="post" autocomplete="off" action="Usuario/destruir">
				<label>User:</label>
				<input type="text" readonly="readonly" value="<?=$usuario->user?>">
				<br>
				
				<label>Password:</label>
				<input type="password" name="password" required="required">
				<br>
				
				<label></label>
				<input  class="button" type="submit" name="confirmar" value="Confirmar">
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