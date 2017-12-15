<?php
include_once 'app/repositorios/RepositorioFoto.inc.php';

if (!ControlSesion::sesion_iniciada()) {
	header('location:'. SERVIDOR, true, 301);
}

Conexion::abrir_conexion();
$foto = RepositorioFoto::obtener_foto($id, Conexion::obtener_conexion());
Conexion::cerrar_conexion();

$nombre = explode('/', $foto->get_ruta());
$nombre = array_filter($nombre);

header('Content-disposition: attachment; filename='. $nombre[2]);
header('Content-type: image/jpeg');
readfile($foto->get_ruta());
?>