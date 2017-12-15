<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Este botón despliega la barra de navegación</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="<?php echo SERVIDOR ?>" class="navbar-brand"><span class="glyphicon glyphicon-camera" aria-hidden="true"></span> Diego PhotoStudio</a>
		</div>
		<div class="navbar-collapse collapse" id="navbar">
			<ul class="nav navbar-nav navbar-right">
				<?php
				if (!ControlSesion::sesion_iniciada()) {
				?>
				<li><a href="<?php echo RUTA_REGISTRO ?>"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Registro</a></li>
				<li><a href="<?php echo RUTA_LOGIN ?>"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Iniciar sesión</a></li>
				<?php
				} else {
                                ?>
                                <li><a href="<?php echo RUTA_MI_GALERIA ?>"><i class="fa fa-glass" aria-hidden="true"></i> Mi galeria</a></li>
                                <?php
					if ($_SESSION['privilegio'] == "Administrador") {
				?>
					<li><a href="<?php echo RUTA_INFORMACION ?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Ver información</a></li>
					<li class="dropdown" id="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-gift" aria-hidden="true"></i> Eventos
						</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo RUTA_REGISTRO_EVENTO ?>">Registro</a></li>
							<li><a href="<?php echo RUTA_ELEGIR_EVENTO ?>">Agregar fotos a un evento</a></li>
						</ul>
					</li>
					<li class="dropdown" id="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							<span class="glyphicon glyphicon-user" aria-hidden="true"></span> Gestión de Usuarios
						</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo RUTA_REGISTRO ?>">Registro</a></li>
							<li><a href="<?php echo RUTA_ADMINISTRAR_USUARIO ?>">Administrar usuarios</a></li>
						</ul>
					</li>
				<?php
					} else {
				?>
					<li class="dropdown" id="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							<span class="glyphicon glyphicon-user"></span> Perfil
						</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo RUTA_INFORMACION ?>">Ver información</a></li>
							<li><a href="<?php echo RUTA_EDITAR_USUARIO. '/'. $_SESSION['id_usuario'] ?>">Editar información</a></li>
							<li><a href="<?php echo RUTA_CLAVE. '/'. $_SESSION['id_usuario'] ?>">Cambiar contraseña</a></li>
						</ul>
					</li>
				<?php
					}
				?>
				<li><a href="<?php echo RUTA_LOGOUT ?>"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Cerrar sesión</a></li>
				<?php
				}
				?>
			</ul>
		</div>
	</div>
</nav>
<br>
<br>
<br>
<br>