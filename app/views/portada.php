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
		<meta name="description" content="Tu descripción aquí">
		<meta name="keywords" content="RMF, framework, php, aplicaciones web">
		<meta name="author" content="Robert Sallent">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
				
		<!-- TITULO DE LA PÁGINA Y FAVICON -->
		<title><?=Config::get('app_name')?> - PORTADA</title>
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

		<section id="content" class="flex-container">
		
			<?php Template::aside(); ?>
			
			<main class="flex8">
    			<h2>Presentación</h2>
    			<p>Este framework PHP, ha sido desarrollado con fines docentes por <b>Robert Sallent</b> 
    			para los cursos de desarrollo de aplicaciones que imparte en diferentes centros
    			formativos, entre los que se encuentran:
    			<b>CIFO Vallès</b>, <b>CIFO la Violeta</b>, <b>ActiuHumà</b> e <b>IES Jaume Viladoms</b>.</p>
    			
    			<p>Se trata de un Framework de trabajo con <b>arquitectura Modelo-Vista-Controlador</b> para entender los
    			conceptos y trabajarlos en clase, siendo paso previo a trabajar con otros frameworks como 
    			<b>CodeIgniter</b>, <b>Symfony</b> o <b>Laravel</b></p>
    			  			
    			<p>A lo largo del curso se desarrollan varios proyectos usando este pequeño framework
    			para conocer las características comunes a este tipo de herramientas de trabajo, así como
    			comprender cómo funcionan internamente.</p>
    			
    			<p>Este framework implementa:</p>
    			<ul>
    				<li>Arquitectura MVC.</li>
    				<li>Fichero de configuración independiente.</li>
    				<li>Autoloader de clases.</li>
    				<li>Router / dispatcher para la gestión de peticiones.</li>
    				<li>Control de sesiones y gestión básica de usuarios.</li>
    				<li>URLs amigables con <i>mod_rewrite</i>.</li>
    				<li>Librerías para la conexión con BDD (<i>mysqli / PDO</i>), subida de ficheros, generación de XML...</li>
    				<li>Un sencillo motor de templates basado en una clase con métodos estáticos</li>
    				<li>Instalación mediante Composer.</li>
    			</ul>
    			
    			<p><b>NO ES 100% SEGURO</b>, así que no se debe usar para desarrollos en entornos de producción. Para cualquier duda
    			o consulta,	contactad conmigo mediante twitter.</p>
    		</main>
    		
		</section>
		<?php 
		  Template::footer();
		?>
    </body> 
</html>