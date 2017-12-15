<?php
include_once 'app/repositorios/ValidadorFoto.inc.php';
include_once 'app/repositorios/RepositorioEvento.inc.php';
include_once 'app/repositorios/RepositorioFoto.inc.php';
include_once 'app/repositorios/RepositorioFotoMarca.inc.php';
include_once 'app/clases/Foto.class.php';
include_once 'app/clases/Foto_marca.class.php';
include_once 'app/repositorios/CrearMarcaAgua.inc.php';
include_once 'app/repositorios/RepositorioUsuario.inc.php';

if (!ControlSesion::sesion_iniciada() || (ControlSesion::sesion_iniciada() && $_SESSION['privilegio'] !== 'Administrador')) {
	header('location:'. SERVIDOR, true, 301);
}

Conexion::abrir_conexion();
if (!RepositorioEvento::evento_existe($id, Conexion::obtener_conexion())) {
	header('location:'. RUTA_NOT_FOUND, true, 301);
}

if (isset($_POST['enviar'])) {
        $usuarios = RepositorioUsuario::obtener_todos(Conexion::obtener_conexion());
	$nombre_foto = $_FILES['files']['name'];
	$tipo_foto = $_FILES['files']['type'];
	$tmp_foto = $_FILES['files']['tmp_name'];
	$mensaje = array();
	$evento = RepositorioEvento::obtener_evento_por_id($id, Conexion::obtener_conexion());
	$marcadeagua = 'img/watermark.png';
	for ($i = 0; $i < count($tipo_foto); $i++) { 
		$validador = new ValidadorFoto($tipo_foto[$i]);
		if ($validador->get_error_foto() === '') {
			$foto_direccion = 'eventos/'. $evento->get_carpeta(). '/'. $nombre_foto[$i];
			$foto_evento = $_SERVER['DOCUMENT_ROOT']. '/EstudioFotografico/'. $foto_direccion;
			$foto = new Foto('', $foto_direccion, $id);
			$foto_insertada = @RepositorioFoto::insertar_foto($foto, Conexion::obtener_conexion());
			$confirmacion = array();
			if ($foto_insertada) {
				move_uploaded_file($tmp_foto[$i], $foto_evento);
				$origen = $foto_direccion;
				$destino = 'eventos/'. $evento->get_carpeta(). '/marca_'. $nombre_foto[$i];
				$destino_temporal = tempnam("tmp/","tmp");
				marcadeagua($origen, $marcadeagua, $destino_temporal, 10);
				$fp=fopen($destino,"w");
				fputs($fp,fread(fopen($destino_temporal,"r"),filesize($destino_temporal)));
				fclose($fp);
				$id_foto = RepositorioFoto::obtener_id(Conexion::obtener_conexion());
				$foto_marca = new Foto_marca('', $destino, $id_foto);
				$foto_marca_insertada = @RepositorioFotoMarca::insertar_foto_marca($foto_marca, Conexion::obtener_conexion(), $id_foto);
				if ($foto_marca_insertada) {
					move_uploaded_file($destino_temporal, $_SERVER['DOCUMENT_ROOT']. '/'. $destino);
                                        for ($j = 0; $j < count($usuarios); $j++) {
                                                mail($usuarios[$j]->get_email(), "Diego PhotoStudio", "Nuevas im�genes se han subido al evento ". $evento->get_nombre());
                                        }
				}
				$confirmacion[] = "<br><div class='alert alert-success' role='alert' style='font-family: cursive'>El archivo ". $nombre_foto[$i]. " fue registrado con éxito.</div>";
			}
		}
	}
}
Conexion::cerrar_conexion();

$titulo = 'Agregar fotos';
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php
		if(!isset($titulo) || empty($titulo)) {
			$titulo = 'Diego PhotoStudio';
		}
		?>
		<title><?php echo $titulo ?></title>
		<link rel="stylesheet" href="<?php echo RUTA_CSS ?>bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo RUTA_CSS ?>font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo RUTA_CSS ?>estilos.min.css">
		<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	   	<script>
	    	$(function() { 
		       	$("#file").on("change", function() {
			        $("#vista-previa").html('');
			        var archivos = document.getElementById('file').files;
			        var navegador = window.URL || window.webkitURL;
			        for(x=0; x<archivos.length; x++) {
			            var size = archivos[x].size;
			            var type = archivos[x].type;
			            var name = archivos[x].name;
			            if (size > 1024*1024) {
			                $("#vista-previa").append("<p style='color: red'>El archivo "+name+" supera el máximo permitido 1MB</p>");
			            } else if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png' && type != 'image/gif') {
			                $("#vista-previa").append("<p style='color: red'>El archivo "+name+" no es del tipo de imagen permitida.</p>");
			            } else {
			                var objeto_url = navegador.createObjectURL(archivos[x]);
			                $("#vista-previa").append("<img src="+objeto_url+" width='250' height='250' style='border: 2px solid black; margin-right: 5px; margin-bottom: 5px'>");
			            }
		        	}
	   			})
	    	});
	    </script>
 	</head>
	<body>

<?php
include_once 'plantillas/navbar.inc.php';
?>

<div class="container">
	<div class="jumbotron text-center">
		<h1>Agregar fotos al evento</h1>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<div class="panel panel-default" id="form">
				<div class="panel-body text-center">
					<form role="form" method="POST" action="<?php echo RUTA_AGREGAR_FOTOS. '/'. $id ?>" enctype="multipart/form-data">
						<div class="form-group">
							<label><h5>Agregar fotos al evento</h5></label>
							<input type="file" class="form-control" id="file" name="files[]" style="background-color: black; color: white; font-family: cursive" multiple>
						</div>
						<button type="submit" class="btn" name="enviar" style="font-family: cursive; border: 5px solid black; backgroung-color: rgba(255, 255, 255, 0.0) !important">Enviar</button>
						<br>
						<br>
						<?php
						if (isset($_POST['enviar'])) {
							$validador->mostrar_error_foto();
						}
						if (isset($confirmacion)) {
							for ($i = 0; $i < count($confirmacion); $i++) { 
								echo $confirmacion[$i];
								echo $id_foto;
							}
						}
						?>
						<div id="vista-previa"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
include_once 'plantillas/documento-cierre.inc.php';
?>