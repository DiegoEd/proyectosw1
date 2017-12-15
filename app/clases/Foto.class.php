<?php
class Foto {
	private $id;
	private $ruta;
	private $id_evento;

	public function __construct($id, $ruta, $id_evento) {
		$this->id = $id;
		$this->ruta = $ruta;
		$this->id_evento = $id_evento;
	}

	public function get_id() {
		return $this->id;
	}

	public function get_ruta() {
		return $this->ruta;
	}

	public function get_id_evento() {
		return $this->id_evento;
	}
}
?>