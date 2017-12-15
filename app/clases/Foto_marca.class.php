<?php
class Foto_marca {
	private $id;
	private $ruta;
	private $id_foto;

	public function __construct($id, $ruta, $id_foto) {
		$this->id = $id;
		$this->ruta = $ruta;
		$this->id_foto = $id_foto;
	}

	public function get_id() {
		return $this->id;
	}

	public function get_ruta() {
		return $this->ruta;
	}

	public function get_id_foto() {
		return $this->id_foto;
	}
}
?>