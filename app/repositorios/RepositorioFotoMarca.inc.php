<?php
class RepositorioFotoMarca {
	public static function insertar_foto_marca($foto, $conexion) {
		$foto_marca_insertada = false;
		if (isset($conexion)) {
			try {
				$sql = "INSERT INTO foto_marca(ruta, id_foto) VALUES(:ruta, :id_foto)";
				$sentencia = $conexion->prepare($sql);
				$sentencia->bindParam(":ruta", $foto->get_ruta(), PDO::PARAM_STR);
				$sentencia->bindParam(":id_foto", $foto->get_id_foto(), PDO::PARAM_INT);
				$foto_marca_insertada = $sentencia->execute();
			} catch(Exception $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $foto_marca_insertada;
	}

	public static function obtener_todos($id_evento, $conexion) {
		$fotos_marca = null;
		if (isset($conexion)) {
			try {
				include_once 'app/clases/Foto_marca.class.php';
				$sql = "SELECT foto_marca.id as fm_id,foto_marca.ruta as fm_ruta, foto_marca.id_foto as fm_foto FROM foto_marca, foto WHERE id_evento = :id_evento AND foto.id = id_foto";
				$sentencia = $conexion->prepare($sql);
				$sentencia->bindParam(":id_evento", $id_evento, PDO::PARAM_INT);
				$sentencia->execute();
				$resultado = $sentencia->fetchAll();
				if (count($resultado)) {
					foreach ($resultado as $fila) {
						$fotos_marca[] = new Foto_marca($fila['fm_id'], $fila['fm_ruta'], $fila['fm_foto']);
					}
				}
			} catch(PDOException $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $fotos_marca;
	}

	public static function obtener_foto($id, $conexion) {
		$foto_marca = null;
		if (isset($conexion)) {
			try {
				include_once 'app/clases/Foto_marca.class.php';
				$sql = "SELECT * FROM foto_marca WHERE id = :id";
				$sentencia = $conexion->prepare($sql);
				$sentencia->bindParam(":id", $id, PDO::PARAM_INT);
				$sentencia->execute();
				$resultado = $sentencia->fetch();
				if (!empty($resultado)) {
					$foto_marca = new Foto_marca($resultado['id'], $resultado['ruta'], $resultado['id_foto']);
				}
			} catch(PDOException $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $foto_marca;
	}
}
?>