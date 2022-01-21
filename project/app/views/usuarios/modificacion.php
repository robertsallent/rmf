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
    	<meta name="description" content="Modificación del perfil de <?=$usuario->user?>">
    	<meta name="keywords" content="modificación, datos, perfil, usuario">
    	<meta name="author" content="Robert Sallent">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    			
    	<!-- TITULO DE LA PÁGINA Y FAVICON -->
    	<title><?=Config::get('app_name')?> - Modificación del perfil de <?=$usuario->user?></title>
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
			<h2>Formulario de modificación de datos</h2>
			<p>
				<img src="images/samples/info.png" class="icono" alt="informacion">
				Modifica tus datos mediante el formulario.
			</p>
			
			<?php if(!empty($success)){ ?>
    			<section class="exito">
        			<?=$success?>
        		</section>
    		<?php } ?>
    		
    		<?php if(!empty($failure)){ ?>
    			<section class="error">
        			<?=$failure?>
        		</section>
    		<?php } ?>
    		
			<div class="flex-container">	
				<!-- FORMULARIO DE MODIFICACIÓN DE DATOS -->	
    			<form class="formulario flex4" method="post" enctype="multipart/form-data" autocomplete="off" action="Usuario/actualizar">
    
    				<label>User:</label>
    				<input type="text" name="user" required="required" readonly="readonly" value="<?=$usuario->user?>">
    				<br>
    				
    				<label>Password actual:</label>
    				<input type="password" name="password" required="required">
    				<br>
    				
    				<label>Nuevo password:</label>
    				<input type="password" name="newpassword" pattern=".{4,16}" title="4 a 16 caracteres">
    				<span class="mini">En blanco para no modificar el actual</span>
    				<br>
    			   				
    				<label>Nombre:</label>
    				<input type="text" name="nombre" required="required" value="<?=$usuario->nombre?>">
    				<br>
    				
    				<label>Email:</label>
    				<input type="email" name="email" required="required" value="<?=$usuario->email?>">
    				<br>
    				
    				<label>Nueva imagen:</label>
    				<input type="hidden" name="MAX_FILE_SIZE" value="<?=$max_image_size?>">		
    				<input type="file" accept="image/*" name="imagen">
    				<span class="mini">max <?=intval($max_image_size/1024)?>KB</span>
    				<br>
    				
    				<label></label>
    				<input class="button" type="submit" name="modificar" value="modificar">
    				<br>
    			</form>
    			
    			<!-- IMAGEN DEL USUARIO Y LINK AL FORMULARIO DE BAJA -->
    			<section class="flex1">
        			<figure>
    					<img class="usuarioActual" alt="<?=$usuario->user?>" src="<?php echo $usuario->imagen? $usuario->imagen : Config::get('default_user_image');?>">
    					<figcaption class="centrado">
    						<a href="Usuario/borrar">
    							<span class="fakeButton">Darse de baja</span>
                			</a>
    					</figcaption>
    				</figure> 				
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