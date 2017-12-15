<?php
include_once 'app/repositorios/RepositorioFoto.inc.php';
include_once 'app/repositorios/RepositorioFotoMarca.inc.php';

if (!ControlSesion::sesion_iniciada()) {
	header('location:'. SERVIDOR, true, 301);
}

Conexion::abrir_conexion();
if (!RepositorioFoto::foto_existe($id, Conexion::obtener_conexion())) {
	header('location:'. RUTA_NOT_FOUND, true, 301);
}

$foto_marca = RepositorioFotoMarca::obtener_foto($id, Conexion::obtener_conexion());
$nombre = explode('/', $foto_marca->get_ruta());
$nombre = array_filter($nombre);

$titulo = 'Compra';

include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/navbar.inc.php';
?>

<div class="container">
	<div class="jumbotron text-center">
		<h1>Compra de foto - PayPal</h1>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-body text-center">
					<img src="../<?php echo $foto_marca->get_ruta() ?>" width ="520px" height="300px" style="border: 2px solid black">
					<br>
					<br>
					<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="POST">
						<input type="hidden" name="cmd" value="_xclick">
				                <input type="hidden" name="business" value="vendedor0000@hotmail.com">
				                <input type="hidden" name="item_name" value="<?php echo $nombre[2] ?>">
				                <input type="hidden" name="item_number" value="<?php echo $foto_marca->get_id() ?>">
				                <input type="hidden" name="currency_code" value="USD">
				                <input type="hidden" name="amount" value="10.00">
				                <input type="image" src="http://www.paypal.com/es_XC/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
						<input type="hidden" name="no_shipping" value="1">
				                <input type="hidden" name="return" value="<?php echo RUTA_PAGO_REALIZADO. '/'. $id ?>">
				                <input type="hidden" name="cancel_return" value="<?php echo RUTA_IMAGEN. '/'. $id ?>">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
include_once 'plantillas/documento-cierre.inc.php';
?>					