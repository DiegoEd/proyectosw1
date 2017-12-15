<?php
class ControlSesion {
	public static function iniciar_sesion($id, $nombre, $privilegio) {
		if (session_id() == '') {
			session_start();
		}
		$_SESSION['id_usuario'] = $id;
		$_SESSION['nombre_usuario'] = $nombre;
		$_SESSION['privilegio'] = $privilegio;
	}

	public static function cerrar_sesion() {
		if (session_id() == '') {
			session_start();
		}
		if (isset($_SESSION['id_usuario'])) {
			unset($_SESSION['id_usuario']);
		}
		if (isset($_SESSION['nombre_usuario'])) {
			unset($_SESSION['nombre_usuario']);
		}
		if (isset($_SESSION['privilegio'])) {
			unset($_SESSION['privilegio']);
		}
		session_destroy();
	}

	public static function sesion_iniciada() {
		if (session_id() == '') {
			session_start();
		}
		if (isset($_SESSION['id_usuario']) && isset($_SESSION['nombre_usuario']) && isset($_SESSION['privilegio'])) {
			return true;
		} else {
			return false;
		}
	}
}
?>