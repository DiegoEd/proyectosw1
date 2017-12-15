<?php
include_once 'RepositorioUsuario.inc.php';

class ValidadorRegistro {
	private $error_nombre;
	private $error_direccion;
	private $error_email;
	private $error_clave1;
	private $error_clave2;
	private $error_foto;

	public function __construct($nombre, $direccion, $email, $clave1, $clave2, $foto, $conexion) {
		$this->error_nombre = $this->validar_nombre($nombre);
		$this->error_direccion = $this->validar_direccion($direccion);
		$this->error_email = $this->validar_email($email, $conexion);
		$this->error_clave1 = $this->validar_clave1($clave1);
		$this->error_clave2 = $this->validar_clave2($clave1, $clave2);
		$this->error_foto = $this->validar_foto($foto);
	}

	private function variable_iniciada($variable) {
		if (isset($variable) && !empty($variable)) {
			return true;
		} else {
			return false;
		}
	}

	private function validar_nombre($nombre) {
		if (!$this->variable_iniciada($nombre)) {
			return "Debes escribir tu nombre.";
		}
		return "";
	}

	private function validar_direccion($direccion) {
		if (!$this->variable_iniciada($direccion)) {
			return "Debes escribir tu direccion.";
		}
		return "";
	}

	private function validar_email($email, $conexion) {
		if (!$this->variable_iniciada($email)) {
			return "Debes proporcionar un email";
		}
		if (RepositorioUsuario::email_existe($email, $conexion)) {
			return "El email ya está en uso. Pruebe con otro email o <a href='#'>intente recuperar su contraseña</a>";
		}
		return "";
	}

	private function validar_clave1($clave1) {
		if (!$this->variable_iniciada($clave1)) {
			return "Debes escribir una contraseña.";
		}
		return "";
	}

	private function validar_clave2($clave1, $clave2) {
		if (!$this->variable_iniciada($clave1)) {
			return "Primero debe rellenar la contraseña.";
		}
		if (!$this->variable_iniciada($clave2)) {
			return "Debes repetir tu contraseña.";
		}
		if ($clave1 !== $clave2) {
			return "Ambas contraseñas deben coincidir.";
		}
		return "";
	}

	private function validar_foto($foto) {
		if (!$this->variable_iniciada($foto)) {
			return "Debe seleccionar una foto suya.";
		}
		if ($foto !== "image/jpeg" && $foto !== "image/jpg" && $foto !== "image/png") {
			return "Debe subir un archivo de tipo imagen";
		}
		return "";
	}

	public function registro_valido() {
		if ($this->error_nombre === "" && $this->error_direccion === "" && $this->error_email === "" && $this->error_clave1 === "" && $this->error_clave2 === "" && $this->error_foto === "" ) {
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

	public function mostrar_error_email() {
		if ($this->error_email !== "") {
			echo '<br><div class="alert alert-danger" role="alert" style="font-family: cursive">'. $this->error_email. '</div>';
		}
	}

	public function mostrar_error_clave1() {
		if ($this->error_clave1 !== "") {
			echo '<br><div class="alert alert-danger" role="alert" style="font-family: cursive">'. $this->error_clave1. '</div>';
		}
	}

	public function mostrar_error_clave2() {
		if ($this->error_clave2 !== "") {
			echo '<br><div class="alert alert-danger" role="alert" style="font-family: cursive">'. $this->error_clave2. '</div>';
		}
	}

	public function mostrar_error_foto() {
		if ($this->error_foto !== "") {
			echo '<br><div class="alert alert-danger" role="alert" style="font-family: cursive">'. $this->error_foto. '</div>';
		}
	}
}
?>