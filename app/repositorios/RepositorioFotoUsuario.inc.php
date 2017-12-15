<?php
class RepositorioFotoUsuario {
	public static function insertar_foto_usuario($foto_usuario, $conexion) {
		$foto_usuario_insertado = false;
		if (isset($conexion)) {
			try {
				$sql = "INSERT INTO foto_usuario(id_usuario, id_foto) VALUES(:id_usuario, :id_foto)";
				$sentencia = $conexion->prepare($sql);
				$sentencia->bindParam(":id_usuario", $foto_usuario->get_id_usuario(), PDO::PARAM_INT);
				$sentencia->bindParam(":id_foto", $foto_usuario->get_id_foto(), PDO::PARAM_INT);
				$foto_usuario_insertado = $sentencia->execute();
			} catch(Exception $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $foto_usuario_insertado;
	}

	public static function foto_usuario_existe($id_usuario, $id_foto, $conexion) {
		$foto_usuario_existe = false;
		if (isset($conexion)) {
			try {
				$sql = "SELECT * FROM foto_usuario WHERE id_usuario = :id_usuario AND id_foto = :id_foto";
				$sentencia = $conexion->prepare($sql);
				$sentencia->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
				$sentencia->bindParam(":id_foto", $id_foto, PDO::PARAM_INT);
				$sentencia->execute();
				$resultado = $sentencia->fetchAll();
				if (count($resultado)) {
					$foto_usuario_existe = true;
				}
			} catch(PDOException $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $foto_usuario_existe;
	}
}
?>