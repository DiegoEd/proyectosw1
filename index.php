<?php
include_once 'app/config.inc.php';
include_once 'app/clases/Conexion.class.php';
include_once 'app/repositorios/ControlSesion.inc.php';

$componentes_url = parse_url($_SERVER['REQUEST_URI']);
$ruta = $componentes_url['path'];
$partes_ruta = explode('/', $ruta);
$partes_ruta = array_filter($partes_ruta);
$partes_ruta = array_slice($partes_ruta, 0);

$ruta_elegida = 'app/vistas/home.php';


if($partes_ruta[0] == 'EstudioFotografico') {
	//$ruta_elegida = 'app/vistas/home.php';
	if (count($partes_ruta) == 1) {
		$ruta_elegida = 'app/vistas/home.php';
	}
	else if(count($partes_ruta) == 2) {
		switch ($partes_ruta[1]) {
			case 'registro':
				$ruta_elegida = 'app/vistas/registro.php';
				break;
			case 'login':
				$ruta_elegida = 'app/vistas/login.php';
				break;
			case 'administrar-usuario':
				$ruta_elegida = 'app/vistas/administrar-usuario.php';
				break;
			case 'not-found':
				$ruta_elegida = 'app/vistas/not-found.php';
				break;
			case 'logout':
				$ruta_elegida = 'app/vistas/logout.php';
				break;
			case 'informacion':
				$ruta_elegida = 'app/vistas/informacion.php';
				break;
			case 'registro-evento':
				$ruta_elegida = 'app/vistas/registro-evento.php';
				break;
			case 'elegir-evento':
				$ruta_elegida = 'app/vistas/elegir-evento.php';
				break;
			case 'imagen':
				$ruta_elegida = 'app/vistas/imagen.php';
				break;
	                case 'mi-galeria':
	                        $ruta_elegida = 'app/vistas/mi-galeria.php';
	                        break;
		}
	} else if (count($partes_ruta) == 3) {
		switch ($partes_ruta[1]) {
			case 'registro-correcto':
				$nombre = $partes_ruta[2];
				$ruta_elegida = 'app/vistas/registro-correcto.php';
				break;
			case 'editar-usuario':
				$id = $partes_ruta[2];
				$ruta_elegida = 'app/vistas/editar-usuario.php';
				break;
			case 'cambiar-clave':
				$id = $partes_ruta[2];
				$ruta_elegida = 'app/vistas/cambiar-clave.php';
				break;
			case 'ubicacion':
				$id = $partes_ruta[2];
				$ruta_elegida = 'app/vistas/ubicacion-evento.php';
				break;
			case 'agregar-fotos':
				$id = $partes_ruta[2];
				$ruta_elegida = 'app/vistas/agregar-fotos.php';
				break;
			case 'galeria':
				$id = $partes_ruta[2];
				$ruta_elegida = 'app/vistas/galeria.php';
				break;
			case 'descarga':
				$id = $partes_ruta[2];
				$ruta_elegida = 'app/vistas/descarga.php';
				break;
			case 'imagen':
				$id = $partes_ruta[2];
				$ruta_elegida = 'app/vistas/imagen.php';
				break;
	        case 'pago-realizado':
	            $id = $partes_ruta[2];
	            $ruta_elegida = 'app/vistas/pago-realizado.php';
	            break;
		}
	}
}


include_once $ruta_elegida;
?>							