<?php
include_once 'app/repositorios/RepositorioEvento.inc.php';
include_once 'phpqrcode/qrlib.php';

Conexion::abrir_conexion();
$evento = RepositorioEvento::obtener_evento_por_id($id, Conexion::obtener_conexion());

if (!RepositorioEvento::evento_existe($id, Conexion::obtener_conexion())) {
	header('location:'. RUTA_NOT_FOUND, true, 301);
}
Conexion::cerrar_conexion();

$url = 'http://estudiofotograficoparcial.hol.es/galeria/'. $evento->get_id();
QRcode::png($url, "temp/01.png", QR_ECLEVEL_M, 4, 4);

$titulo = 'Ubicación del evento';

include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/navbar.inc.php';
?>

<div class="container">
	<div class="jumbotron text-center">
		<h1>Ubicación del evento</h1>
		<h4><?php echo $evento->get_nombre() ?></h4>
	</div>
</div>
<div class="container" id="">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div id="mapa"></div>
					<script>
						var marker;
						var coords = {};

						initMap = function () {
							navigator.geolocation.getCurrentPosition(function () {
								coords = {
								    lng: <?php echo $evento->get_coordenada_x() ?>,
								    lat: <?php echo $evento->get_coordenada_y() ?>,
								};
								setMapa(coords);
							}, function(error) {console.log(error);});
								    
						}

						function setMapa (coords) {
							var map = new google.maps.Map(document.getElementById('mapa'), {
								zoom: 18,
								center: new google.maps.LatLng(<?php echo $evento->get_coordenada_x() ?>, <?php echo $evento->get_coordenada_y() ?>),
							});
							marker = new google.maps.Marker({
								map: map,
								animation: google.maps.Animation.DROP,
								position: new google.maps.LatLng(<?php echo $evento->get_coordenada_x() ?>, <?php echo $evento->get_coordenada_y() ?>),

						    });
							marker.addListener('click', toggleBounce);
						}

						function toggleBounce() {
							if (marker.getAnimation() !== null) {
								marker.setAnimation(null);
							} else {
								marker.setAnimation(google.maps.Animation.BOUNCE);
							}
						}
					</script>
					<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxsWKWSYav-2YuTiD90KcUXVB3hzrbizA&callback=initMap"></script>
					<br>
					<div class="row">
						<div class="col-md-6"><p><b>Nombre:</b> <?php echo $evento->get_nombre() ?>.</p></div>
						<div class="col-md-6"><p><b>Latitud:</b> <?php echo $evento->get_coordenada_x() ?></p></div>
					</div>
					<div class="row">
						<div class="col-md-6"><p><b>Dirección:</b> <?php echo $evento->get_direccion() ?>.</p></div>
						<div class="col-md-6"><p><b>Longitud:</b> <?php echo $evento->get_coordenada_y() ?></p></div>
					</div>
					<p><b>Fecha:</b> <?php echo $evento->get_fecha() ?></p>
					<div class="row">
						<div class="col-md-3"></div>
						<div class="col-md-4 text-center">
							<p><b>Código QR:</b></p>
							<img src="../temp/01.png" style="border: 2px solid black">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
include_once 'plantillas/documento-cierre.inc.php';
?>