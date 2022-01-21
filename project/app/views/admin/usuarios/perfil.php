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
    	<meta name="description" content="Perfil del usuario <?=$u->user?>">
    	<meta name="keywords" content="datos, usuario, <?=$u->user?>">
    	<meta name="author" content="Robert Sallent">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    			
    	<!-- TITULO DE LA PÁGINA Y FAVICON -->
    	<title><?=Config::get('app_name')?> - Perfil del usuario <?=$u->user?></title>
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
			<h2>Perfil de usuario</h2>
			<p>
				<img src="images/samples/info.png" class="icono" alt="informacion">
				Visualizando los datos del usuario: 
				<?="<b>$u->user</b> ($u->nombre)"?>
			</p>

			<div class="flex-container">	
				<div class="flex4">	
        			<table id="detalles">
        				<tr>
        					<th colspan="2">Datos del usuario <?=$u->user?></th>
        				</tr>
        				<tr>
        					<td>Nombre de usuario:</td>
        					<td><?=$u->user?></td>
        				</tr>
        				<tr>
        					<td>Nombre:</td>
        					<td><?=$u->nombre?></td>
        				<tr>
        					<td>Email:</td>
        					<td><a class="subrayado href="mailto:<?=$u->email?>"><?=$u->email?></a></td>
        				</tr>
        				<tr>
        					<td>Nivel de privilegio:</td>
        					<td><?=$u->privilegio?></td>
        				</tr>
        				<tr>
        					<td>Administrador:</td>
        					<td><b><?=$u->admin?'SI':'NO'?></b></td>
        				</tr>
        				<tr>
        					<td>Fecha de alta:</td>
        					<td><?=date_format(new DateTime($u->created_at),'d/m/Y')?></td>
        				</tr>
        				<tr>
        					<td>Hora de alta:</td>
        					<td><?=date_format(new DateTime($u->created_at),'h:i:s')?></td>
        				</tr>
        			</table>
    			</div>
    			
    			<!-- IMAGEN DEL USUARIO Y LINK AL FORMULARIO DE BAJA -->
    			<section class="flex1">
        			<figure>
    					<img class="usuarioActual" alt="<?=$u->user?>" src="<?php echo $u->imagen? $u->imagen : Config::get('default_user_image');?>">
    					<div class="centrado">
            			    <a href='Usuario/editaradmin/<?=$u->id?>'>
            			    	<img class='icono' alt='editar' src='images/buttons/edit.png'>
            			    </a>
            			    <a href='Usuario/borraradmin/<?=$u->id?>'>
            			    	<img class='icono' alt='eliminar' src='images/buttons/delete.png'>
            			   	</a>
    					</div>
    				</figure> 				
    			</section>
			</div>	
		</main>
		
		<div class="links">
			<a id="back" onclick="history.back();">Atrás</a>
			<a href="Usuario/listar">Lista de usuarios</a>
			<a href="">Inicio</a>
		</div>
		
		<?php 
		  Template::footer();
		?>
    </body>
</html>