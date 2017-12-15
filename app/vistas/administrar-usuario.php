<?php
include_once 'app/clases/Usuario.class.php';
include_once 'app/repositorios/RepositorioUsuario.inc.php';

if (!ControlSesion::sesion_iniciada() || $_SESSION['privilegio'] != "Administrador") {
	header('location:'. SERVIDOR, true, 301);
}

$titulo = 'Administración de usuarios';

include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/navbar.inc.php';
?>

<div class="container">
	<div class="jumbotron text-center">
		<h1>Administración de usuarios</h1>
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
								<th><h4 id="th">Dirección</h4></th>
								<th><h4 id="th">Email</h4></th>
								<th><h4 id="th">Privilegio</h4></th>
								<th><h4 id="th">Foto</h4></th>
								<th><h4 id="th">Acción</h4></th>
							</tr>
						</thead>
						<tbody>
							<?php
							Conexion::abrir_conexion();
							$usuarios = RepositorioUsuario::obtener_todos(Conexion::obtener_conexion());
							Conexion::cerrar_conexion();
							if (count($usuarios)) {
								for ($i = 0; $i < count($usuarios); $i++) { 
									echo '<tr style="font-family: cursive">';
									echo '<td>'. $usuarios[$i]->get_nombre(). '</td>';
									echo '<td>'. $usuarios[$i]->get_direccion(). '</td>';
									echo '<td>'. $usuarios[$i]->get_email(). '</td>';
									echo '<td>'. $usuarios[$i]->get_privilegio(). '</td>';
									echo '<td><img src="'. $usuarios[$i]->get_foto(). '" alt="perfil" height="50" width="60" style="border: 2px solid black"></td>';
									echo '<td width="10%"><a href="'. RUTA_EDITAR_USUARIO. '/'. $usuarios[$i]->get_id(). '"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editar</a><br><a href="#"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Eliminar</a><br><a href="'. RUTA_CLAVE. '/'. $usuarios[$i]->get_id(). '"><i class="fa fa-lock"></i> Cambiar contraseña</a></td>';
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