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
    	<meta name="description" content="Perfil de <?=$usuario->user?>">
    	<meta name="keywords" content="datos, perfil, usuario">
    	<meta name="author" content="Robert Sallent">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    			
    	<!-- TITULO DE LA PÁGINA Y FAVICON -->
    	<title><?=Config::get('app_name')?> - Perfil de <?=$usuario->user?></title>
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
				Estos son tus datos de usuario.
			</p>
			
			<div class="flex-container">	
				<div class="flex4">	
        			<table id="detalles">
        				<tr>
        					<th colspan="2">Mis datos</th>
        				</tr>
        				<tr>
        					<td>Usuario:</td>
        					<td><?=$usuario->user?></td>
        				</tr>
        				<tr>
        					<td>Nombre:</td>
        					<td><?=$usuario->nombre?></td>
        				</tr>
        				<tr>
        					<td>Email:</td>
        					<td><a href="mailto:<?=$usuario->email?>"><?=$usuario->email?></a></td>
        				</tr>
        				<tr>
        					<td>Fecha de alta:</td>
        					<td><?=date_format(new DateTime($usuario->created_at),'d/m/Y')?></td>
        				</tr>
        				<tr>
        					<td>Hora de alta:</td>
        					<td><?=date_format(new DateTime($usuario->created_at),'h:i:s')?></td>
        				</tr>
        			</table>
    			</div>
    			
    			<!-- IMAGEN DEL USUARIO Y LINK AL FORMULARIO DE BAJA -->
    			<section class="flex1">
        			<figure>
    					<img class="usuarioActual" alt="<?=$usuario->user?>" src="<?php echo $usuario->imagen? $usuario->imagen : Config::get('default_user_image');?>">
    					<figcaption class="centrado">
    						<a href="Usuario/editar">
    							<span class="fakeButton">Editar mis datos</span>
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