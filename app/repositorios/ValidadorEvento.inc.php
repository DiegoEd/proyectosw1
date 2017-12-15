<?php
include_once 'RepositorioEvento.inc.php';

class ValidadorEvento {
	private $error_nombre;
	private $error_direccion;
	private $error_coordenada_x;
	private $error_coordenada_y;

	public function __construct($nombre, $direccion, $coordenada_x, $coordenada_y, $conexion) {
		$this->error_nombre = $this->validar_nombre($nombre, $conexion);
		$this->error_direccion = $this->validar_direccion($direccion);
		$this->error_coordenada_x = $this->validar_coordenada_x($coordenada_x);
		$this->error_coordenada_y = $this->validar_coordenada_y($coordenada_y);
	}

	private function variable_iniciada($variable) {
		if (isset($variable) && !empty($variable)) {
			return true;
		} else {
			return false;
		}
	}

	private function validar_nombre($nombre, $conexion) {
		if (!$this->variable_iniciada($nombre)) {
			return "Debes escribir un nombre para este evento.";
		}
		if (RepositorioEvento::nombre_existe($nombre, $conexion)) {
			return "El nombre del evento ya existe.";
		}
		return "";
	}

	private function validar_direccion($direccion) {
		if (!$this->variable_iniciada($direccion)) {
			return "Debes introducir una dirección.";
		}
		return "";
	}

	private function validar_coordenada_x($coordenada_x) {
		if (!$this->variable_iniciada($coordenada_x)) {
			return "No hay latitud.";
		}
		return "";
	}

	private function validar_coordenada_y($coordenada_y) {
		if (!$this->variable_iniciada($coordenada_y)) {
			return "No hay longitud.";
		}
		return "";
	}

	public function registro_evento_valido() {
		if ($this->error_nombre === "" && $this->error_direccion === "" && $this->error_coordenada_x === "" && $this->error_coordenada_y === "") {
			return true;
		} else {
			return false;
		}
	}

	public function mostrar_error_nombre() {
		if ($this->error_nombre !== "") {
			echo '<br><div class="alert alert-danger" role="alert" style="font-family: cursive">'. $this->error_nombre. '</div>';
		}
	}

	public function mostrar_error_direccion() {
		if ($this->error_direccion !== "") {
			echo '<br><div class="alert alert-danger" role="alert" style="font-family: cursive">'. $this->error_direccion. '</div>';
		}
	}

	public function mostrar_error_coordenada_x() {
		if ($this->error_coordenada_x !== "") {
			echo '<br><div class="alert alert-danger" role="alert" style="font-family: cursive">'. $this->error_coordenada_x. '</div>';
		}
	}

	public function mostrar_error_coordenada_y() {
		if ($this->error_coordenada_y !== "") {
			echo '<br><div class="alert alert-danger" role="alert" style="font-family: cursive">'. $this->error_coordenada_y. '</div>';
		}
	}
}
?>