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
    	<meta name="description" content="ERROR en la operación">
    	<meta name="keywords" content="error">
    	<meta name="author" content="Robert Sallent">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    			
    	<!-- TITULO DE LA PÁGINA Y FAVICON -->
    	<title><?=Config::get('app_name')?> - ERROR en la operación</title>
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
    		<h1>Error</h1>
    		<p>Se ha producido el siguiente problema:</p>
    		
    		<section class="error">
    			<?=$mensaje?>
    		</section>
		</main>
		
		<div class="links">
			<a id="back" onclick="history.back();">Volver</a>
			<a href="">Inicio</a>
		</div>
		
		<?php 
		  Template::footer();
		?>
    </body>   
</html>