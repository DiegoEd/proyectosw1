<?php
include_once 'app/repositorios/RepositorioUsuario.inc.php';
include_once 'app/repositorios/ValidadorRegistro.inc.php';
include_once 'app/clases/Usuario.class.php';

if (ControlSesion::sesion_iniciada() && $_SESSION['privilegio'] != "Administrador") {
	header('location:'. SERVIDOR, true, 301);
}

if (isset($_POST['enviar'])) {
	Conexion::abrir_conexion();
	$tipo_foto = $_FILES['foto']['type'];
	$validador = new ValidadorRegistro($_POST['nombre'], $_POST['direccion'], $_POST['email'], $_POST['clave1'], $_POST['clave2'], $tipo_foto, Conexion::obtener_conexion());
	if ($validador->registro_valido()) {
		$foto_direccion = 'imagen_usuario/'. $_FILES['foto']['name'];
		$foto = $_SERVER['DOCUMENT_ROOT']. '/'. $foto_direccion;
		$usuario  = new Usuario('', $_POST['nombre'], $_POST['direccion'], $_POST['email'], password_hash($_POST['clave1'], PASSWORD_DEFAULT), $_POST['privilegio'], $foto_direccion);
		$usuario_insertado = @RepositorioUsuario::insertar_usuario($usuario, Conexion::obtener_conexion());
		if ($usuario_insertado) {
			move_uploaded_file($_FILES['foto']['tmp_name'], $foto);
			header('location:'. RUTA_REGISTRO_CORRECTO. '/'. $usuario->get_nombre(), true, 301);
		}
	}
	Conexion::cerrar_conexion();
}

$titulo = "Registro";

include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/navbar.inc.php';
?>

<div class="container">
	<div class="jumbotron text-center">
		<h1>Registro de Usuario</h1>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<div class="panel panel-default" id="form">
				<div class="panel-body text-center">
					<form role="form" method="POST" enctype="multipart/form-data" action="<?php echo RUTA_REGISTRO ?>">
						<div class="form-group">
							<label><h5>Nombre</h5></label>
							<input type="text" class="form-control" name="nombre" style="background-color: black; color: white; font-family: cursive">
							<?php
							if (isset($_POST['enviar'])) {
								$validador->mostrar_error_nombre();
							}
							?>
						</div>
						<div class="form-group">
							<label><h5>Dirección</h5></label>
							<input type="text" class="form-control" name="direccion" style="background-color: black; color: white; font-family: cursive">
							<?php
							if (isset($_POST['enviar'])) {
								$validador->mostrar_error_direccion();
							}
							?>
						</div>
						<div class="form-group">
							<label><h5>Email</h5></label>
							<input type="email" class="form-control" name="email" style="background-color: black; color: white; font-family: cursive">
							<?php
							if (isset($_POST['enviar'])) {
								$validador->mostrar_error_email();
							}
							?>
						</div>
						<div class="form-group">
							<label><h5>Contraseña</h5></label>
							<input type="password" class="form-control" name="clave1" style="background-color: black; color: white; font-family: cursive">
							<?php
							if (isset($_POST['enviar'])) {
								$validador->mostrar_error_clave1();
							}
							?>
						</div>
						<div class="form-group">
							<label><h5>Repetir contraseña</h5></label>
							<input type="password" class="form-control" name="clave2" style="background-color: black; color: white; font-family: cursive">
							<?php
							if (isset($_POST['enviar'])) {
								$validador->mostrar_error_clave2();
							}
							?>
						</div>
						<div class="form-group">
							<label><h5>Privilegio</h5></label>
							<select class="form-control" name="privilegio" style="background-color: black; color: white; font-family: cursive">
								<?php
								if (!ControlSesion::sesion_iniciada()) {
									Conexion::abrir_conexion();
									if (!RepositorioUsuario::administrador_existe(Conexion::obtener_conexion())) {
										echo '<option>Administrador</option>';
									}
								} else {
									echo '<option>Administrador</option>';
								}
								?>
								<option>Normal</option>
							</select>
						</div>
						<div class="form-group">
							<label><h5>Foto</h5></label>
							<input type="file" class="form-control" name="foto" style="background-color: black; color: white; font-family: cursive">
							<?php
							if (isset($_POST['enviar'])) {
								$validador->mostrar_error_foto();
							}
							?>
						</div>
						<button type="submit" class="btn" name="enviar" style="font-family: cursive; border: 5px solid black; backgroung-color: rgba(255, 255, 255, 0.0) !important">Enviar datos</button>
						<button type="reset" class="btn" style="font-family: cursive; border: 5px solid black; backgroung-color: rgba(255, 255, 255, 0.0) !important">Limpiar datos</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
include_once 'plantillas/documento-cierre.inc.php';
?>