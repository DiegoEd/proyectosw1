<?php
include_once 'app/clases/Usuario.class.php';
include_once 'app/repositorios/RepositorioUsuario.inc.php';

if (!ControlSesion::sesion_iniciada()) {
	header('location:'. SERVIDOR, true, 301);
}

Conexion::abrir_conexion();
$usuario = RepositorioUsuario::obtener_usuario_por_id($_SESSION['id_usuario'], Conexion::obtener_conexion());
Conexion::cerrar_conexion();

$titulo = 'Información personal';

include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/navbar.inc.php';
?>

<div class="container">
	<div class="jumbotron text-center">
		<h1>Información personal</h1>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<table class="table table-condensed">
						<tbody>
							<tr style="font-family: cursive">
								<td width="50%" class="text-right"><b>Nombre:</b></td>
								<td width="50%"><?php echo $usuario->get_nombre() ?></td>
							</tr>
							<tr style="font-family: cursive">
								<td width="50%" class="text-right"><b>Direccion:</b></td>
								<td width="50%"><?php echo $usuario->get_direccion() ?></td>
							</tr>
							<tr style="font-family: cursive">
								<td width="50%" class="text-right"><b>Email:</b></td>
								<td width="50%"><?php echo $usuario->get_email() ?></td>
							</tr>
							<!--tr style="font-family: cursive">
								<td width="50%" class="text-right"><b>Contraseña (encriptada):</b></td>
								<td width="50%"><?php echo $usuario->get_clave() ?></td>
							</tr-->
							<tr style="font-family: cursive">
								<td width="50%" class="text-right"><b>Privilegio:</b></td>
								<td width="50%"><?php echo $usuario->get_privilegio() ?></td>
							</tr>
							<tr style="font-family: cursive">
								<td width="50%" class="text-right"><b>Foto:</b></td>
								<td width="50%"><img src="<?php echo $usuario->get_foto() ?>" width="200px" height="200px" style="border: 2px solid black"></td>
							</tr>
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