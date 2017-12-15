<?php
include_once 'app/repositorios/RepositorioUsuario.inc.php';
include_once 'app/repositorios/ValidadorLogin.inc.php';

if (ControlSesion::sesion_iniciada()) {
	header('location:'. SERVIDOR, true, 301);
}

if (isset($_POST['login'])) {
	Conexion::abrir_conexion();
	$validador = new ValidadorLogin($_POST['email'], $_POST['clave'], Conexion::obtener_conexion());
	if ($validador->get_error() === '' && !is_null($validador->get_usuario())) {
		ControlSesion::iniciar_sesion($validador->get_usuario()->get_id(), $validador->get_usuario()->get_nombre(), $validador->get_usuario()->get_privilegio());
		header('location:'. SERVIDOR, true, 301);
	}
	Conexion::cerrar_conexion();
}

$titulo = 'Login';

include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/navbar.inc.php';
?>

<div class="container">
	<div class="jumbotron text-center">
		<h1>Inicio de sesión</h1>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<div class="panel panel-default text-center" style="background-color: rgba(255, 255, 255, 0.3); border: 10px solid black">
				<div class="panel-body" style="background-color: rgba(255, 255, 255, 0.3)">
					<form role="form" method="POST" action="<?php echo RUTA_LOGIN ?>">
						<h2>Introduce tus datos</h2>
						<br>
						<label><h5>Email</h5></label>
						<input type="email" name="email" class="form-control" placeholder="Introduzca su email" style="background-color: black; color: white; font-family: cursive">
						<br>
						<label><h5>Contraseña</h5></label>
						<input type="password" name="clave" class="form-control" placeholder="Introduzca su contraseña" style="background-color: black; color: white; font-family: cursive">
						<?php
						if (isset($_POST['login'])) {
							echo $validador->mostrar_error();
						}
						?>
						<br>
						<button type="submit" name="login" class="btn" style="font-family: cursive; border: 5px solid black; backgroung-color: rgba(255, 255, 255, 0.0) !important">Iniciar sesión</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
include_once 'plantillas/documento-cierre.inc.php';
?>