<?php
$titulo = "¡Registro correcto!";

include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/navbar.inc.php';
?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default" style="background-color: rgba(255, 255, 255, 0.3)">
				<div class="panel-body text-center">
					<p><h4><span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span> ¡Gracias por registrarte <b><?php echo $nombre ?></b>!</h4></p>
					<br>
					<p><h4><a href="<?php echo RUTA_LOGIN ?>">Inicia sesión</a></h4></p>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
include_once 'plantillas/documento-cierre.inc.php';
?>