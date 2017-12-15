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

$usuario = RepositorioUsuario::obtener_usuario_por_id($id, Conexion::obtener_conexion());

if (isset($_POST['enviar'])) {
	if (!empty($_FILES['foto']['type'])) {
		$foto_anterior = $_SERVER['DOCUMENT_ROOT']. '/EstudioFotografico/'. $usuario->get_foto();
		$foto = 'imagen_usuario/'. $_FILES['foto']['name'];
		$tipo_foto = $_FILES['foto']['type'];
	} else {
		$foto = $usuario->get_foto();
		$tipo_foto = 'image/png';
	}
	$foto_direccion = $_SERVER['DOCUMENT_ROOT']. '/EstudioFotografico/'. $foto;
	$validador = new ValidadorRegistro($_POST['nombre'], $_POST['direccion'], 'qwerty', 'qwerty', 'qwerty', $tipo_foto, Conexion::obtener_conexion());
	if ($validador->registro_valido()) {
		$usuario = new Usuario($id, $_POST['nombre'], $_POST['direccion'], '', '', $_POST['privilegio'], $foto);
		$usuario_editado = RepositorioUsuario::editar_usuario($usuario, Conexion::obtener_conexion());
		if ($usuario_editado) {
			if (!empty($_FILES['foto']['type'])) {
				unlink($foto_anterior);
				move_uploaded_file($_FILES['foto']['tmp_name'], $foto_direccion);
			}
			header('location:'. RUTA_ADMINISTRAR_USUARIO, true, 301);
		}
	}
}
Conexion::cerrar_conexion();

$titulo = 'Editar usuario';

include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/navbar.inc.php';
?>

<div class="container">
	<div class="jumbotron text-center">
		<h1>Editar datos</h1>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<img src="../<?php echo $usuario->get_foto(); ?>" height="227" width="227" style="border: 2px solid black">
				</div>
			</div>
		</div>
		<div class="col-md-9">
			<div class="panel panel-default" id="form">
				<div class="panel-body text-center">
					<form role="form" method="POST" enctype="multipart/form-data" action="<?php echo RUTA_EDITAR_USUARIO. '/'. $id ?>">
						<div class="form-group">
							<label><h5>Nombre</h5></label>
							<input type="text" class="form-control" name="nombre" value="<?php echo $usuario->get_nombre() ?>" style="background-color: black; color: white; font-family: cursive">
						</div>
						<?php
						if (isset($_POST['enviar'])) {
							$validador->mostrar_error_nombre();
						}
						?>
						<div class="form-group">
							<label><h5>Dirección</h5></label>
							<input type="text" class="form-control" name="direccion" value="<?php echo $usuario->get_direccion() ?>" style="background-color: black; color: white; font-family: cursive">
						</div>
						<?php
						if (isset($_POST['enviar'])) {
							$validador->mostrar_error_direccion();
						}
						?>
						<div class="form-group">
							<label><h5>Email</h5></label>
							<input type="email" class="form-control" value="<?php echo $usuario->get_email() ?>" style="background-color: black; color: white; font-family: cursive" disabled>
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
									Conexion::cerrar_conexion();
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
						</div>
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