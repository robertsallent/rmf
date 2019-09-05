<?php
/*
 FICHERO: app/templates/Template.php
 CLASE: Template

 Clase que contiene algunos métodos estáticos para crear las zonas comunes
 de las páginas de nuestro sitio (header, footer, menú...)

 Dependencias:
 - app/config/Config.php

 Autor: Robert Sallent
 Última revisión: 12/04/2019
 */

class Template{	

    // Pone el <header> de la página
	public static function header(){?>
		<!--  HEADER DE LA PÁGINA -->
		<header class="flex-container">
			<figure class="flex1">
				<a href="">
					<img alt="Robs Micro Framework logo" src="images/logos/logo.png">
				</a>
			</figure>
			<hgroup class="flex8">
				<h1><?=Config::get('app_name')?></h1>
				<h2><?=Config::get('company_name')?></h2>
			</hgroup>
		</header>
	<?php }
	
	
	// Pone el formulario de login o logout de la página (definidos a continuación)
	public static function loginForms($usuario){
	    empty($usuario)? self::login() : self::logout($usuario);
	}
	
	
	// Pone el formulario de LOGIN
	private static function login(){?>
		<!-- FORMULARIO DE LOGIN -->
		<form method="post" id="login" autocomplete="off">
			<input type="text" placeholder="usuario" name="user" required="required" maxlength="16">
			<input type="password" placeholder="clave" name="password" required="required" maxlength="16">
			<input class="button" type="submit" name="login" value="Login">
			<a href="Usuario/crear">Registro</a>
		</form>
	<?php }
	
	
	// Pone el formulario de LOGOUT
	private static function logout($usuario){	?>
		<div id="logout">
			<span>
				Hola 
				<a href="Usuario/perfil" title="mis datos"><?=$usuario->nombre?></a>
				<?=" <span class='email'>($usuario->email)</span> "?> 			
				<?= $usuario->admin? ', eres administrador':''?>
			</span>	
			
			<!-- FORMULARIO DE LOGOUT -->			
			<form method="post">
				<input class="button" type="submit" name="logout" value="Logout">
			</form>
		</div>
	<?php }
	
	
	// Pone el menú principal
	public static function menu($usuario){ ?>
		<nav class="flex-container">
			<!-- MENÚ DE USUARIO -->
			<ul class="menu flex1">
				<li><a href="">Inicio</a></li>
			</ul>
			
			<!-- MENÚ DE ADMINISTRADOR -->
			<?php if($usuario && $usuario->admin){?>
			<ul class="menu flex1">
				<li><a href="admin">ADMIN</a></li>
			</ul>
			<?php }	?>
		</nav>
	<?php 
	}
	
	// Pone el contenido lateral con enlaces
	public static function aside(){	?>
		<!-- CONTENIDO LATERAL CON ENLACES -->
    	<aside id="social" class="flex1 flex-container">
        	<figure class="flex1">
            	<a href="https://robertsallent.com" rel="author" hreflang="es">
            	<img src="images/logos/logo.png" alt="Robert Sallent">
            	</a>
        	</figure>
        	<figure class="flex1">
        		<a href="https://twitter.com/robertsallent">
        			<img src="images/logos/twitter.png" alt="Twitter">
        		</a>
        	</figure>
        	<figure class="flex1">
        		<a href="https://www.linkedin.com/in/robert-sallent-l%C3%B3pez-4187a866/?originalSubdomain=es">
        			<img src="images/logos/linkedin.png" alt="LinkedIn">
        		</a>
        	</figure>
        	<figure class="flex1">
            	<a href="https://juegayestudia.com">
            		<img src="images/logos/jye.png" alt="Juega y Estudia">
            	</a>
        	</figure>
    	</aside>
	<?php }
	
	// Pone el footer de la página
	public static function footer(){	?>
		<!-- FOOTER DE LA PÁGINA -->
		<footer class="flex-container">
			<summary class="flex2">
    			<a href="https://github.com/robertsallent/rmf">RobS micro Framework</a>
    			 para fines docentes.<br>
    			Creado por <a rel="author" href="http://www.robertsallent.com">Robert Sallent</a>
    			en <a href="https://www.facebook.com/cifovalles">CIFO del Vallès</a>.
			</summary>
			<figure class="flex1">
				<img src="images/logos/wide.png" alt="RobS Micro Framework">
			</figure>
		</footer>
	<?php }
}