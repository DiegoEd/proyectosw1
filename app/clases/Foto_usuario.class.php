<?php
class Foto_usuario {
	private $id;
	private $id_usuario;
	private $id_foto;

	public function __construct($id, $id_usuario, $id_foto) {
		$this->id = $id;
		$this->id_usuario = $id_usuario;
		$this->id_foto = $id_foto;
	}

	public function get_id() {
		return $this->id;
	}

	public function get_id_usuario() {
		return $this->id_usuario;
	}

	public function get_id_foto() {
		return $this->id_foto;
	}
}
?>