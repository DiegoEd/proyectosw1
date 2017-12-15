<?php
class RepositorioFoto {
	public static function insertar_foto($foto, $conexion) {
		$foto_insertada = false;
		if (isset($conexion)) {
			try {
				$sql = "INSERT INTO foto(ruta, id_evento) VALUES(:ruta, :id_evento)";
				$sentencia = $conexion->prepare($sql);
				$sentencia->bindParam(":ruta", $foto->get_ruta(), PDO::PARAM_STR);
				$sentencia->bindParam(":id_evento", $foto->get_id_evento(), PDO::PARAM_INT);
				$foto_insertada = $sentencia->execute();
			} catch(Exception $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $foto_insertada;
	}

        public static function obtener_galeria($id_usuario, $conexion) {
		$galeria = null;
		if (isset($conexion)) {
			try {
				include_once 'app/clases/Foto.class.php';
				$sql = "SELECT foto.id as idf, foto.ruta as rutaf, foto.id_evento as id_eventof FROM foto, foto_usuario WHERE foto.id = id_foto AND id_usuario = :id_usuario";
				$sentencia = $conexion->prepare($sql);
				$sentencia->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
				$sentencia->execute();
				$resultado = $sentencia->fetchAll();
				if (count($resultado)) {
					foreach ($resultado as $fila) {
						$galeria[] = new Foto($fila['idf'], $fila['rutaf'], $fila['id_eventof']);
					}
				}
			} catch(PDOException $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $galeria;
	}

	public static function obtener_todos($id_evento, $conexion) {
		$fotos = null;
		if (isset($conexion)) {
			try {
				include_once 'app/clases/Foto.class.php';
				$sql = "SELECT * FROM foto WHERE id_evento = :id_evento";
				$sentencia = $conexion->prepare($sql);
				$sentencia->bindParam(":id_evento", $id_evento, PDO::PARAM_INT);
				$sentencia->execute();
				$resultado = $sentencia->fetchAll();
				if (count($resultado)) {
					foreach ($resultado as $fila) {
						$fotos[] = new Foto($fila['id'], $fila['ruta'], $fila['id_evento']);
					}
				}
			} catch(PDOException $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $fotos;
	}

	public static function obtener_id($conexion) {
		$id = null;
		if (isset($conexion)) {
			try {
				$sql = "SELECT * FROM foto ORDER BY id DESC LIMIT 1";
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

	public static function obtener_foto($id, $conexion) {
		$foto = null;
		if (isset($conexion)) {
			try {
				include_once 'app/clases/Foto.class.php';
				$sql = "SELECT * FROM foto WHERE id = :id";
				$sentencia = $conexion->prepare($sql);
				$sentencia->bindParam(":id", $id, PDO::PARAM_INT);
				$sentencia->execute();
				$resultado = $sentencia->fetch();
				if (!empty($resultado)) {
					$foto = new Foto($resultado['id'], $resultado['ruta'], $resultado['id_evento']);
				}
			} catch(PDOException $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $foto;
	}

	public static function foto_existe($id, $conexion) {
		$foto_existe = false;
		if (isset($conexion)) {
			try {
				$sql = "SELECT * FROM foto WHERE id = :id";
				$sentencia = $conexion->prepare($sql);
				$sentencia->bindParam(":id", $id, PDO::PARAM_INT);
				$sentencia->execute();
				$resultado = $sentencia->fetchAll();
				if (count($resultado)) {
					$foto_existe = true;
				}
			} catch(PDOException $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $foto_existe;
	}
}
?>