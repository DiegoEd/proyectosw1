<?php
include_once 'app/repositorios/RepositorioEvento.inc.php';
include_once 'app/repositorios/ValidadorEvento.inc.php';
include_once 'app/clases/Evento.class.php';

if (!ControlSesion::sesion_iniciada() || (ControlSesion::sesion_iniciada() && $_SESSION['privilegio'] !== 'Administrador')) {
	header('location:'.SERVIDOR, true, 301);
}

function crear_nombre_carpeta($nombre) {
	$long = strlen($nombre);
	$carpeta = '';
	for ($i = 0; $i < $long; $i++) { 
		if ($nombre[$i] == ' ') {
			$carpeta .= '_';
		} else if ($nombre[$i] == 'á') {
			$carpeta .= 'a';
		} else if ($nombre[$i] == 'é') {
			$carpeta .= 'e';
		} else if ($nombre[$i] == 'í') {
			$carpeta .= 'i';
		} else if ($nombre[$i] == 'ó') {
			$carpeta .= 'o';
		} else if ($nombre[$i] == 'ú') {
			$carpeta .= 'u';
		} else if ($nombre[$i] == 'Á') {
			$carpeta .= 'A';
		} else if ($nombre[$i] == 'É') {
			$carpeta .= 'E';
		} else if ($nombre[$i] == 'Í') {
			$carpeta .= 'I';
		} else if ($nombre[$i] == 'Ó') {
			$carpeta .= 'O';
		} else if ($nombre[$i] == 'Ú') {
			$carpeta .= 'U';
		} else {
			$carpeta .= $nombre[$i];
		}
	}
	return $carpeta;
}

if (isset($_POST['enviar'])) {
	Conexion::abrir_conexion();
	$validador = new ValidadorEvento($_POST['nombre'], $_POST['direccion'], $_POST['coord_x'], $_POST['coord_y'], Conexion::obtener_conexion());
	if ($validador->registro_evento_valido()) {
		$nombre_carpeta = crear_nombre_carpeta($_POST['nombre']);
		$evento = new Evento('', $_POST['nombre'], $nombre_carpeta, $_POST['direccion'], $_POST['coord_x'], $_POST['coord_y'], '');
		$evento_insertado = RepositorioEvento::insertar_evento($evento, Conexion::obtener_conexion());
		if ($evento_insertado) {
			$carpeta = $_SERVER['DOCUMENT_ROOT']. '/eventos/'. $nombre_carpeta;
			if (!file_exists($carpeta)) {
				mkdir($carpeta, 0777, true);
			}
			$id_evento = RepositorioEvento::obtener_id(Conexion::obtener_conexion());
			header('location:'. RUTA_AGREGAR_FOTOS. '/'. $id_evento, true, 301);
		}
	}
	Conexion::cerrar_conexion();
}

$titulo = 'Registro de eventos';

include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/navbar.inc.php';
?>

<div class="container">
	<div class="jumbotron text-center">
		<h1>Registro de eventos</h1>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default" id="form">
				<div class="panel-body text-center">
					<form role="form" method="POST" action="<?php echo RUTA_REGISTRO_EVENTO ?>">
						<div class="form-group">
							<label><h5>Nombre del evento</h5></label>
							<input type="text" class="form-control" name="nombre" style="background-color: black; color: white; font-family: cursive">
						</div>
						<?php
						if (isset($_POST['enviar'])) {
							$validador->mostrar_error_nombre();
						}
						?>
						<div class="form-group">
							<label><h5>Dirección</h5></label>
							<input type="text" class="form-control" name="direccion" style="background-color: black; color: white; font-family: cursive">
						</div>
						<?php
						if (isset($_POST['enviar'])) {
							$validador->mostrar_error_direccion();
						}
						?>
						<div class="form-group">
							<label><h5>Coordenadas</h5></label>
							<div id="mapa"></div>
							<br>
							<input type="text" class="form-control" name="coord_x" id="coordx" style="background-color: black; color: white; font-family: cursive">
							<br>
							<?php
							if (isset($_POST['enviar'])) {
								$validador->mostrar_error_coordenada_x();
								echo '<br>';
							}
							?>
							<input type="text" class="form-control" name="coord_y" id="coordy" style="background-color: black; color: white; font-family: cursive">
							<?php
							if (isset($_POST['enviar'])) {
								$validador->mostrar_error_coordenada_y();
								echo '<br>';
							}
							?>
							<script type="text/javascript">
								var marker;
								var coords = {};

								initMap = function () {
								    navigator.geolocation.getCurrentPosition(function (position) {
								        coords = {
								            lng: position.coords.longitude,
								            lat: position.coords.latitude
								        };
								        setMapa(coords);
								    }, function(error) {console.log(error);});
								    
								}

								function setMapa (coords) {
								    var map = new google.maps.Map(document.getElementById('mapa'), {
								    	zoom: 13,
								        center: new google.maps.LatLng(coords.lat,coords.lng),
								    });
								    marker = new google.maps.Marker({
								    	map: map,
								        draggable: true,
								        animation: google.maps.Animation.DROP,
								        position: new google.maps.LatLng(coords.lat,coords.lng),

								    });
								    marker.addListener('click', toggleBounce);  
								    marker.addListener('dragend', function (event) {
								        document.getElementById("coordx").value = this.getPosition().lat();
								        document.getElementById("coordy").value = this.getPosition().lng();
								    });
								}

								function toggleBounce() {
								  if (marker.getAnimation() !== null) {
								    marker.setAnimation(null);
								  } else {
								    marker.setAnimation(google.maps.Animation.BOUNCE);
								  }
								}
							</script>
							<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxsWKWSYav-2YuTiD90KcUXVB3hzrbizA&callback=initMap&v=3"></script>
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