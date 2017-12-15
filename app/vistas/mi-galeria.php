<?php
include_once 'app/repositorios/RepositorioFoto.inc.php';

if (!ControlSesion::sesion_iniciada()) {
	header('location: '. SERVIDOR, true, 301);
}

Conexion::abrir_conexion();
$galeria = RepositorioFoto::obtener_galeria($_SESSION['id_usuario'], Conexion::obtener_conexion());
Conexion::cerrar_conexion();

$titulo = 'Mi galería';

include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/navbar.inc.php';
?>

<div class="container">
	<div class="jumbotron text-center">
		<h1>Mi galería de imágenes</h1>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel">
				<div class="panel-body">
					<?php for ($i = 0; $i < count($galeria); $i++) {
					?>
					<a href="<?php echo RUTA_DESCARGA. '/'. $galeria[$i]->get_id() ?>"><img src="<?php echo $galeria[$i]->get_ruta() ?>" width="265" height="265" style="border: 2px solid black; margin-right: 5px; margin-bottom: 5px"></a>
					<?php
					} ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
include_once 'plantillas/documento-cierre.inc.php';
?>