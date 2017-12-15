<?php

class ValidadorFoto {
	private $error_foto;

	public function __construct($foto) {
		$this->error_foto = $this->validar_foto($foto);
	}

	private function variable_iniciada($variable) {
		if (isset($variable) && !empty($variable)) {
			return true;
		} else {
			return false;
		}
	}

	private function validar_foto($foto) {
		if (!$this->variable_iniciada($foto)) {
			return "Debe subir un archivo.";
		}
		if ($foto !== "image/jpeg" && $foto !== "image/jpg") {
			return "Uno o más archivos no pudieron ser registrados por no ser imágenes.";
		}
		if ($foto === "image/png") {
			return "No se puede subir imágenes del tipo PNG.";
		}
		return "";
	}

	public function get_error_foto() {
		return $this->error_foto;
	}

	public function mostrar_error_foto() {
		if ($this->error_foto !== "") {
			echo '<br><div class="alert alert-danger" role="alert" style="font-family: cursive">'. $this->error_foto. '</div>';
		}
	}
}
?>