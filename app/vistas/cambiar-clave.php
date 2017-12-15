<?php
include_once 'app/clases/Usuario.class.php';
include_once 'app/repositorios/RepositorioUsuario.inc.php';
include_once 'app/repositorios/ValidadorRegistro.inc.php';

if (!ControlSesion::sesion_iniciada()) {
	header('location:'. SERVIDOR, true, 301);
}

Conexion::abrir_conexion();
if (!RepositorioUsuario::usuario_existe($id, Conexion::obtener_conexion())) {
	header('location:'. RUTA_NOT_FOUND, true, 301);
}

if ($_SESSION['privilegio'] !== 'Administrador' && $_SESSION['id_usuario'] !== $id) {
	header('location:'. SERVIDOR, true, 301);
}

if (isset($_POST['enviar'])) {
	if (empty($_POST['clave1']) && empty($_POST['clave2'])) {
		$error = "Debes escribir una contraseña.";
	} else if (empty($_POST['clave1']) && !empty($_POST['clave2'])) {
		$error = "Debes escribir la contraseña primero.";
	} else if (!empty($_POST['clave1']) && empty($_POST['clave2'])) {
		$error = "Debes repetir la contraseña.";
	} else if ($_POST['clave1'] !== $_POST['clave2']) {
		$error = "Las contraseñas no coinciden.";
	} else {
		$clave_editada = RepositorioUsuario::cambiar_clave($id, password_hash($_POST['clave1'], PASSWORD_DEFAULT), Conexion::obtener_conexion());
		if ($clave_editada) {
			header('location:'. RUTA_ADMINISTRAR_USUARIO, true, 301);
		}
	}
}
Conexion::cerrar_conexion();

$titulo = 'Cambiar contraseña';

include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/navbar.inc.php';
?>

<div class="container">
	<div class="jumbotron text-center">
		<h1>Cambiar contraseña</h1>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<div class="panel panel-default" id="form">
				<div class="panel-body text-center">
					<form role="form" method="POST" action="<?php echo RUTA_CLAVE. '/'. $id ?>">
						<div class="form-group">
							<label>Contraseña</label>
							<input type="password" class="form-control" name="clave1" style="background-color: black; color: white; font-family: cursive">
						</div>
						<div class="form-group">
							<label>Repetir contraseña</label>
							<input type="password" class="form-control" name="clave2" style="background-color: black; color: white; font-family: cursive">
						</div>
						<?php
						if (isset($_POST['enviar'])) {
							echo '<br><div class="alert alert-danger" role="alert" style="font-family: cursive">'. $error. '</div>';
						}
						?>
						<button type="submit" class="btn" name="enviar" style="font-family: cursive; border: 5px solid black; backgroung-color: rgba(255, 255, 255, 0.0) !important">Enviar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
include_once 'plantillas/documento-cierre.inc.php';
?>