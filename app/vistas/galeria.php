<?php
include_once 'app/repositorios/RepositorioEvento.inc.php';
include_once 'app/repositorios/RepositorioFotoMarca.inc.php';
include_once 'app/repositorios/RepositorioFoto.inc.php';

if (!ControlSesion::sesion_iniciada()) {
	header('location:'. SERVIDOR, true, 301);
}

Conexion::abrir_conexion();
if (!RepositorioEvento::evento_existe($id, Conexion::obtener_conexion())) {
	header('location:'. RUTA_NOT_FOUND, true, 301);
}

$evento = RepositorioEvento::obtener_evento_por_id($id, Conexion::obtener_conexion());
$fotos_marca = RepositorioFotoMarca::obtener_todos($id, Conexion::obtener_conexion());
$fotos = RepositorioFoto::obtener_todos($id, Conexion::obtener_conexion());

$titulo = 'Galería de fotos';

include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/navbar.inc.php';
?>

<div class="container">
	<div class="jumbotron text-center">
		<h1>Galería de fotos del evento</h1>
		<h4><?php echo $evento->get_nombre() ?></h4>
	</div>
</div>
<div class="container">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-12">
					<?php
					for ($i = 0; $i < count($fotos_marca); $i++) {
						$nombre = explode('/', $fotos[$i]->get_ruta());
						$nombre = array_filter($nombre);
					?>
					<a href="<?php echo RUTA_IMAGEN. '/'. $fotos[$i]->get_id() ?>"><img src="../<?php echo $fotos_marca[$i]->get_ruta() ?>" width="360px" height="300px" style="border: 2px solid black; margin-right: 5px; margin-bottom:5px"></a>
					<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
include_once 'plantillas/documento-cierre.inc.php';
?>