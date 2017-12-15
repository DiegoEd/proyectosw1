<?php
class RepositorioUsuario {
	public static function insertar_usuario($usuario, $conexion) {
		$usuario_insertado = false;
		if (isset($conexion)) {
			try {
				$sql = "INSERT INTO usuario(nombre, direccion, email, clave, privilegio, foto) VALUES(:nombre, :direccion, :email, :clave, :privilegio, :foto)";
				$sentencia = $conexion->prepare($sql);
				$sentencia->bindParam(":nombre", $usuario->get_nombre(), PDO::PARAM_STR);
				$sentencia->bindParam(":direccion", $usuario->get_direccion(), PDO::PARAM_STR);
				$sentencia->bindParam(":email", $usuario->get_email(), PDO::PARAM_STR);
				$sentencia->bindParam(":clave", $usuario->get_clave(), PDO::PARAM_STR);
				$sentencia->bindParam(":privilegio", $usuario->get_privilegio(), PDO::PARAM_STR);
				$sentencia->bindParam(":foto", $usuario->get_foto(), PDO::PARAM_STR);
				$usuario_insertado = $sentencia->execute();
			} catch(Exception $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $usuario_insertado;
	}

	public static function editar_usuario($usuario, $conexion) {
		$usuario_editado = false;
		if (isset($conexion)) {
			try {
				$sql = "UPDATE usuario SET nombre = :nombre WHERE id = :id; UPDATE usuario SET direccion = :direccion WHERE id = :id; UPDATE usuario SET privilegio = :privilegio WHERE id = :id; UPDATE usuario SET foto = :foto WHERE id = :id";
				$sentencia = $conexion->prepare($sql);
				$sentencia->bindParam(":nombre", $usuario->get_nombre(), PDO::PARAM_STR);
				$sentencia->bindParam(":direccion", $usuario->get_direccion(), PDO::PARAM_STR);
				$sentencia->bindParam(":privilegio", $usuario->get_privilegio(), PDO::PARAM_STR);
				$sentencia->bindParam(":foto", $usuario->get_foto(), PDO::PARAM_STR);
				$sentencia->bindParam(":id", $usuario->get_id(), PDO::PARAM_INT);
				$usuario_editado = $sentencia->execute();
			} catch(Exception $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $usuario_editado;
	}

	public static function cambiar_clave($id, $clave, $conexion) {
		$clave_cambiada = false;
		if (isset($conexion)) {
			try {
				$sql = "UPDATE usuario SET clave = :clave WHERE id = :id";
				$sentencia = $conexion->prepare($sql);
				$sentencia->bindParam(":clave", $clave, PDO::PARAM_STR);
				$sentencia->bindParam(":id", $id, PDO::PARAM_INT);
				$clave_cambiada = $sentencia->execute();
			} catch(Exception $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $clave_cambiada;
	}

	public static function obtener_todos($conexion) {
		$usuarios = array();
		if (isset($conexion)) {
			try {
				include_once 'app/clases/Usuario.class.php';
				$sql = "SELECT * FROM usuario";
				$sentencia = $conexion->prepare($sql);
				$sentencia->execute();
				$resultado = $sentencia->fetchAll();
				if (count($resultado)) {
					foreach ($resultado as $fila) {
						$usuarios[] = new Usuario($fila['id'], $fila['nombre'], $fila['direccion'], $fila['email'], $fila['clave'], $fila['privilegio'], $fila['foto']);
					}
				} else {
					print 'No hay usuarios';
				}
			} catch(PDOException $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $usuarios;
	}

	public static function usuario_existe($id, $conexion) {
		$usuario_existe = false;
		if (isset($conexion)) {
			try {
				$sql = "SELECT * FROM usuario WHERE id = :id";
				$sentencia = $conexion->prepare($sql);
				$sentencia->bindParam(":id", $id, PDO::PARAM_INT);
				$sentencia->execute();
				$resultado = $sentencia->fetchAll();
				if (count($resultado)) {
					$usuario_existe = true;
				}
			} catch(PDOException $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $usuario_existe;
	}

	public static function email_existe($email, $conexion) {
		$email_existe = false;
		if (isset($conexion)) {
			try {
				$sql = "SELECT * FROM usuario WHERE email = :email";
				$sentencia = $conexion->prepare($sql);
				$sentencia->bindParam(":email", $email, PDO::PARAM_STR);
				$sentencia->execute();
				$resultado = $sentencia->fetchAll();
				if (count($resultado)) {
					$email_existe = true;
				}
			} catch(PDOException $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $email_existe;
	}

	public static function administrador_existe($conexion) {
		$administrador_existe = false;
		if (isset($conexion)) {
			try {
				$sql = "SELECT * FROM usuario WHERE privilegio = 'administrador'";
				$sentencia = $conexion->prepare($sql);
				$sentencia->execute();
				$resultado = $sentencia->fetchAll();
				if (count($resultado)) {
					$administrador_existe = true;
				}
			} catch(PDOException $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $administrador_existe;
	}

	public static function obtener_usuario_por_id($id, $conexion) {
		$usuario = null;
		if (isset($conexion)) {
			try {
				include_once 'app/clases/Usuario.class.php';
				$sql = "SELECT * FROM usuario WHERE id = :id";
				$sentencia = $conexion->prepare($sql);
				$sentencia->bindParam(":id", $id, PDO::PARAM_INT);
				$sentencia->execute();
				$resultado = $sentencia->fetch();
				if (!empty($resultado)) {
					$usuario = new Usuario($resultado['id'], $resultado['nombre'], $resultado['direccion'], $resultado['email'], $resultado['clave'], $resultado['privilegio'], $resultado['foto']);
				}
			} catch(PDOException $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $usuario;
	}

	public static function obtener_usuario_por_email($email, $conexion) {
		$usuario = null;
		if (isset($conexion)) {
			try {
				include_once 'app/clases/Usuario.class.php';
				$sql = "SELECT * FROM usuario WHERE email = :email";
				$sentencia = $conexion->prepare($sql);
				$sentencia->bindParam(":email", $email, PDO::PARAM_STR);
				$sentencia->execute();
				$resultado = $sentencia->fetch();
				if (!empty($resultado)) {
					$usuario = new Usuario($resultado['id'], $resultado['nombre'], $resultado['direccion'], $resultado['email'], $resultado['clave'], $resultado['privilegio'], $resultado['foto']);
				}
			} catch(PDOException $ex) {
				print "ERROR: ". $ex->getMessage();
			}
		}
		return $usuario;
	}
}
?>