<?php
class Usuario {
	private $id;
	private $nombre;
	private $direccion;
	private $email;
	private $clave;
	private $privilegio;
	private $foto;

	public function __construct($id, $nombre, $direccion, $email, $clave, $privilegio, $foto) {
		$this->id = $id;
		$this->nombre = $nombre;
		$this->direccion = $direccion;
		$this->email = $email;
		$this->clave = $clave;
		$this->privilegio = $privilegio;
		$this->foto = $foto;
	}

	public function get_id() {
		return $this->id;
	}

	public function get_nombre() {
		return $this->nombre;
	}
	public function get_direccion() {
		return $this->direccion;
	}
	public function get_email() {
		return $this->email;
	}
	public function get_clave() {
		return $this->clave;
	}
	public function get_privilegio() {
		return $this->privilegio;
	}
	public function get_foto() {
		return $this->foto;
	}

	public function set_nombre($nombre) {
		$this->nombre = $nombre;
	}

	public function set_direccion($direccion) {
		$this->direccion = $direccion;
	}

	public function set_clave($clave) {
		$this->clave = $clave;
	}

	public function set_privilegio($privilegio) {
		$this->privilegio = $privilegio;
	}

	public function set_foto($foto) {
		$this->foto = $foto;
	}
}
?>