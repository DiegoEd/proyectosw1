<?php
include_once 'app/repositorios/RepositorioEvento.inc.php';

if (!ControlSesion::sesion_iniciada() || (ControlSesion::sesion_iniciada() && $_SESSION['privilegio'] !== 'Administrador')) {
	header('location:'. SERVIDOR, true, 301);
}

Conexion::abrir_conexion();
$eventos = RepositorioEvento::obtener_todos(Conexion::obtener_conexion());
Conexion::cerrar_conexion();

$titulo = 'Elegir evento';

include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/navbar.inc.php';
?>

<div class="container">
	<div class="jumbotron text-center">
		<h1>Elegir evento para introducir fotos</h1>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<table class="table table-condensed">
						<thead>
							<tr>
								<th><h4 id="th">Nombre</h4></th>
								<th><h4 id="th">Acción</h4></th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (count($eventos)) {
								for ($i = 0; $i < count($eventos); $i++) { 
									echo '<tr style="font-family: cursive">';
									echo '<td>'. $eventos[$i]->get_nombre(). '</td>';
									echo '<td width="30%"><a href="'. RUTA_AGREGAR_FOTOS. '/'. $eventos[$i]->get_id().'">Agregar fotos al evento</a></td>';
									echo '</tr>';
								}
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
include_once 'plantillas/documento-cierre.inc.php';
?>