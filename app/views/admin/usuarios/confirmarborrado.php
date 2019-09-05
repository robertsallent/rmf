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
		<meta name="description" content="Confirmación de baja de usuario">
		<meta name="keywords" content="baja, eliminar usuario">
		<meta name="author" content="Robert Sallent">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
				
		<!-- TITULO DE LA PÁGINA Y FAVICON -->
		<title><?=Config::get('app_name')?> - Confirmación de baja de usuario</title>
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
			<h2>Eliminación de usuario</h2>
			<p>
    			<img src="images/samples/info.png" class="icono" alt="informacion">
    			Por favor, confirma la eliminación del usuario: 
    			<?="<b>$u->user</b> ($u->nombre)"?>
    		</p>
		
			<div class="flex-container">
			
    			<!-- FORMULARIO DE BAJA DE USUARIO -->
    			<form class="formulario flex4" method="post" autocomplete="off" action="Usuario/destruiradmin">
    				<input type="hidden" name="id" value="<?=$u->id?>">
				
    				<p>Usuario a eliminar: <b><?=$u->user?></b></p>
    				<p>Nombre real: <b><?=$u->nombre?></b></p>
    				<p>Email: <b><?=$u->email?></b></p>
    				
    				<input class="button" type="submit" name="confirmar" value="Confirmar borrado">
    			</form>
    			<div class="flex1">
					<figure>
						<img class="usuarioActual" alt="<?=$u->user?>" src="<?php echo $u->imagen? $u->imagen : Config::get('default_user_image');?>">
						<div class="centrado">
							<a href='Usuario/perfiladmin/<?=$u->id?>'>
            			    	<img class='icono' alt='ver' src='images/buttons/view.png'>
            			   	</a>
            			    <a href='Usuario/editaradmin/<?=$u->id?>'>
            			    	<img class='icono' alt='editar' src='images/buttons/edit.png'>
            			    </a>
    					</div>    					
					</figure> 
				</div>
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