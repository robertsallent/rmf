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
    	<meta name="description" content="Listado de usuarios">
    	<meta name="keywords" content="usuarios, lista">
    	<meta name="author" content="Robert Sallent">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    			
    	<!-- TITULO DE LA PÁGINA Y FAVICON -->
    	<title><?=Config::get('app_name')?> - Listado de usuarios</title>
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
			<h2>Lista de usuarios registrados</h2>
			<p>
				<img src="images/samples/info.png" class="icono" alt="informacion">
				Lista de usuarios registrados en la aplicación <?=Config::get('app_name')?>
			</p>
			
			<?php if(empty($usuarios)){ ?>
			
		    <section class="error">
			    <p>No se encontraron resultados.</p>
    		</section>
    		
			<?php }else{ ?>
		 	<table class="listado"> 
		 	<tr>
		 		<th>Imagen</th>
		 		<th>Usuario</th>
		 		<th>Nombre</th>
		 		<th>Email</th>
		 		<th>Operaciones</th>
		 	</tr> 
			   
			    <?php foreach($usuarios as $u){
			       echo "<tr onclick='location.href=\"Usuario/perfiladmin/$u->id\"'>";
			       echo "<td>";
			       echo "<img class='fotousuario' src='".($u->imagen? $u->imagen : Config::get('default_user_image'))."' alt='Foto de perfil del usuario $u->user'></td>"; 
			       echo "<td>$u->user</td>";
			       echo "<td>$u->nombre</td>";
			       echo "<td><a class='subrayado' href='mailto:$u->email'>$u->email</a></td>";
			       echo "<td>";
			       echo "<a href='Usuario/perfiladmin/$u->id'>";
			       echo "<img class='icono' alt='ver' src='images/buttons/view.png'>";
			       echo "</a>";
			       echo "<a href='Usuario/editaradmin/$u->id'>";
			       echo "<img class='icono' alt='editar' src='images/buttons/edit.png'>";
			       echo "</a>";
			       echo "<a href='Usuario/borraradmin/$u->id'>";
			       echo "<img class='icono' alt='eliminar' src='images/buttons/delete.png'>";
			       echo "</a>";
                   echo "</td>";
                   echo "</tr>";
			    }?>
			   
		 	</table>   
			<?php } ?>
			<div class="derecha">
				<a href="Usuario/crear">
					<img class="boton" src="images/buttons/create.png">
					Crear un nuevo usuario
				</a>
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