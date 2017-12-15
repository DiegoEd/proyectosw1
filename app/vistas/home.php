<?php
include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/navbar.inc.php';

include_once 'app/repositorios/RepositorioEvento.inc.php';
?>

<div class="container">
	<div class="jumbotron text-center">
		<h1>Diego PhotoStudio</h1>
		<h3>Eventos</h3>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<div class="panel panel-default">
				<div class="panel-body">
					<table class="table table-condensed">
						<thead>
							<tr>
								<th><h4 id="th">Nombre</h4></th>
								<th><h4 id="th">Dirección</h4></th>
								<th><h4 id="th">Ubicación</h4></th>
								<th><h4 id="th">Fecha</h4></th>
							</tr>
						</thead>
						<tbody>
							<?php
							Conexion::abrir_conexion();
							$eventos = RepositorioEvento::obtener_todos(Conexion::obtener_conexion());
							Conexion::cerrar_conexion();
							if (count($eventos)) {
								for ($i = 0; $i < count($eventos); $i++) { 
									echo '<tr style="font-family: cursive">';
									echo '<td>'. $eventos[$i]->get_nombre(). '</td>';
									echo '<td>'. $eventos[$i]->get_direccion(). '</td>';
									echo '<td><a href="'. RUTA_UBICACION. '/'. $eventos[$i]->get_id().'">mirar mapa</a></td>';
									echo '<td>'. $eventos[$i]->get_fecha(). '</td>';
									echo '</tr>';
								}
							} else {
								echo "No hay eventos";
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