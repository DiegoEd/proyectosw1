<?php
class Evento {
	private $id;
	private $nombre;
	private $carpeta;
	private $direccion;
	private $coordenada_x;
	private $coordenada_y;
	private $fecha;

	public function __construct($id, $nombre, $carpeta, $direccion, $coordenada_x, $coordenada_y, $fecha) {
		$this->id = $id;
		$this->nombre = $nombre;
		$this->carpeta = $carpeta;
		$this->direccion = $direccion;
		$this->coordenada_x = $coordenada_x;
		$this->coordenada_y = $coordenada_y;
		$this->fecha = $fecha;
	}

	public function get_id() {
		return $this->id;
	}

	public function get_nombre() {
		return $this->nombre;
	}

	public function get_carpeta() {
		return $this->carpeta;
	}

	public function get_direccion() {
		return $this->direccion;
	}

	public function get_coordenada_x() {
		return $this->coordenada_x;
	}

	public function get_coordenada_y() {
		return $this->coordenada_y;
	}

	public function get_fecha() {
		return $this->fecha;
	}

	public function set_direccion($direccion) {
		$this->direccion = $direccion;
	}
}
?>