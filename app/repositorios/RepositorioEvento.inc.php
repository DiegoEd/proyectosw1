<?php
class RepositorioEvento {
	public static function insertar_evento($evento, $conexion) {
		$evento_insertado = false;
		if (isset($conexion)) {
			try {
				$sql = "INSERT INTO evento(nombre, carpeta, direccion, coordenada_x, coordenada_y, fecha) VALUES(:nombre, :carpeta, :direccion, :coordenada_x, :coordenada_y, NOW())";
				$sentencia = $conexion->prepare($sql);
				$sentencia->bindParam(":nombre", $evento->get_nombre(), PDO::PARAM_STR);
				$sentencia->bindParam(":carpeta", $evento->get_carpeta(), PDO::PARAM_STR);
				$sentencia->bindParam(":direccion", $evento->get_direccion(), PDO::PARAM_STR);
				$sentencia->bindParam(":coordenada_x", $evento->get_coordenada_x(), PDO::PARAM_STR);
				$sentencia->bindParam(":coordenada_y", $evento->get_coordenada_y(), PDO::PARAM_STR);
				$evento_insertado = $sentencia->execute();
			} catch(Exception $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $evento_insertado;
	}

	public static function obtener_todos($conexion) {
		$eventos = array();
		if (isset($conexion)) {
			try {
				include_once 'app/clases/Evento.class.php';
				$sql = "SELECT * FROM evento ORDER BY fecha DESC";
				$sentencia = $conexion->prepare($sql);
				$sentencia->execute();
				$resultado = $sentencia->fetchAll();
				if (count($resultado)) {
					foreach ($resultado as $fila) {
						$eventos[] = new Evento($fila['id'], $fila['nombre'], $fila['carpeta'], $fila['direccion'], $fila['coordenada_x'], $fila['coordenada_y'], $fila['fecha']);
					}
				}
			} catch(PDOException $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $eventos;
	}

	public static function obtener_evento_por_id($id, $conexion) {
		$evento = null;
		if (isset($conexion)) {
			try {
				include_once 'app/clases/Evento.class.php';
				$sql = "SELECT * FROM evento WHERE id = :id";
				$sentencia = $conexion->prepare($sql);
				$sentencia->bindParam(":id", $id, PDO::PARAM_INT);
				$sentencia->execute();
				$resultado = $sentencia->fetch();
				if (!empty($resultado)) {
					$evento = new Evento($resultado['id'], $resultado['nombre'], $resultado['carpeta'], $resultado['direccion'], $resultado['coordenada_x'], $resultado['coordenada_y'], $resultado['fecha']);
				}
			} catch(PDOException $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $evento;
	}

	public static function evento_existe($id, $conexion) {
		$evento_existe = false;
		if (isset($conexion)) {
			try {
				$sql= "SELECT * FROM evento WHERE id = :id";
				$sentencia = $conexion->prepare($sql);
				$sentencia->bindParam(":id", $id, PDO::PARAM_INT);
				$sentencia->execute();
				$resultado = $sentencia->fetchAll();
				if (count($resultado)) {
					$evento_existe = true;
				}
			} catch(PDOException $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $evento_existe;
	}

	public static function nombre_existe($nombre, $conexion) {
		$nombre_existe = false;
		if (isset($conexion)) {
			try {
				$sql = "SELECT * FROM evento WHERE nombre = :nombre";
				$sentencia = $conexion->prepare($sql);
				$sentencia->bindParam(':nombre', $nombre, PDO::PARAM_STR);
				$sentencia->execute();
				$resultado = $sentencia->fetchAll();
				if (count($resultado)) {
					$nombre_existe = true;
				}
			} catch(PDOException $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $nombre_existe;
	}

	public static function obtener_id($conexion) {
		$id = null;
		if (isset($conexion)) {
			try {
				$sql = "SELECT * FROM evento ORDER BY id DESC LIMIT 1";
				$sentencia = $conexion->prepare($sql);
				$sentencia->execute();
				$resultado = $sentencia->fetch();
				$id = $resultado['id'];
			} catch(PDOException $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $id;
	}
}
?>