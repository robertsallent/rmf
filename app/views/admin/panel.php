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
    	<meta name="description" content="Panel de control del administrador">
    	<meta name="keywords" content="panel, control, admin, administrador">
    	<meta name="author" content="Robert Sallent">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    			
    	<!-- TITULO DE LA PÁGINA Y FAVICON -->
    	<title><?=Config::get('app_name')?> - Panel de control del administrador</title>
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
    		<h1>Panel de control</h1>
    		<h2>Operaciones para el administrador</h2>
    		<p>
    			<img src="images/samples/info.png" class="icono" alt="informacion">
    			A continuación se muestran las operaciones que puede hacer el administrador.
    		</p>
    		
    		<div class="flex-container" id="panel">
    			<!-- Gestión de usuarios -->
    			<section class="bloquepanel flex1 flex-container" id="usuarios">
					<figure class="flex1">   
						<img src="<?=Config::get('default_user_image');?>">
						<figcaption>Usuarios</figcaption> 			
					</figure>
					<div class="flex2">
						<ul>
							<li><a href="Usuario/listar">Listar</a></li>
							<li><a href="Usuario/crear">Nuevo</a></li>
						</ul>
					</div>
    			</section>
    			
    			<!-- Gestión de POR HACER 1 -->
    			<section class="bloquepanel flex1 flex-container" id="">
					<figure class="flex1">   
						<img src="<?=Config::get('image_not_found');?>">
						<figcaption>Entidad 1</figcaption> 			
					</figure>
					<div class="flex2">
						<ul>
							<li><a href="#">Operación 1</a></li>
							<li><a href="#">Operación 2</a></li>
						</ul>
					</div>
    			</section>
    			
    			<!-- Gestión de POR HACER 2 -->
    			<section class="bloquepanel flex1 flex-container" id="">
					<figure class="flex1">   
						<img src="<?=Config::get('image_not_found');?>">
						<figcaption>Entidad 2</figcaption> 			
					</figure>
					<div class="flex2">
						<ul>
							<li><a href="#">Operación 1</a></li>
							<li><a href="#">Operación 2</a></li>
						</ul>
					</div>
    			</section>
    			
    				
    			<!-- Estadísticas -->
    			<section class="bloquepanel flex1 flex-container" id="estadisticas">
					<figure class="flex1">   
						<img src="images/samples/stats.png">
						<figcaption>Estadísticas</figcaption> 			
					</figure>
					<div class="flex2">
						<ul>
							<li><?=$registrados?> usuarios registrados</li>
						</ul>
					</div>
    			</section>
    		</div>
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