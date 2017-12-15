<?php
include_once 'app/repositorios/RepositorioFotoUsuario.inc.php';
include_once 'app/clases/Foto_usuario.class.php';

if (!ControlSesion::sesion_iniciada()) {
	header('location:'. SERVIDOR, true, 301);
}

Conexion::abrir_conexion();
if (RepositorioFotoUsuario::foto_usuario_existe($_SESSION['id_usuario'], $id, Conexion::obtener_conexion())) {
	header('location:'. SERVIDOR, true, 301);
}

Conexion::abrir_conexion();
$foto_usuario = new Foto_usuario('', $_SESSION['id_usuario'], $id);
RepositorioFotoUsuario::insertar_foto_usuario($foto_usuario, Conexion::obtener_conexion());
$mensaje = "Compra realizada con éxito";
Conexion::cerrar_conexion();

include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/navbar.inc.php';
?>

<div class="container">
	<div class="jumbotron text-center">
		<h1><?php echo $mensaje ?></h1>
	</div>
</div>

<?php
include_once 'plantillas/documento-cierre.inc.php';
?>