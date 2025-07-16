<?php

require_once './usuarios/ConsultasUsuarios.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ControllerUsuarios {
    private static $database;
    private static $respuesta;

    public function __construct() {
        self::$database = new DataBase();
        self::$respuesta = null;
    }

    public function __destruct() {
        self::$database = null;
        self::$respuesta = null;
    }

    public static function login($name_user, $password) {
        $consulta = new ConsultasUsuarios();
        $usuario = $consulta::getUsr($name_user);

        if ($usuario['status'] === 'ok' && !empty($usuario['data'])) {
            $user = $usuario['data'];

            if (password_verify($password, $user['password'])) {
                // JWT
                $payload = [
                    'iss' => 'http://localhost',      // Emisor
                    'aud' => 'http://localhost',      // Audiencia
                    'iat' => time(),                  // Fecha de emisión
                    'exp' => time() + 86400,           // 3600 = Expira en 1 hora
                    'data' => [
                        'id' => $user['id'],
                        'name_user' => $user['name_user'],
                        'correo' => $user['correo'],
                    ]
                ];

                $jwt = JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');

                // $decoded = JWT::decode($token, new Key('zT9wU!5vYp@34Fk', 'HS256'));

                return [
                    'status' => 'ok',
                    'message' => 'Inicio de sesión exitoso',
                    'token' => $jwt,
                    'usuario' => [
                        'id' => $user['id'],
                        'name_user' => $user['name_user'],
                        'correo' => $user['correo'],
                        // 'rol' => $user['id_rol']
                    ]
                ];
            } else {
                return ['status' => 'error', 'message' => 'Contraseña incorrecta'];
            }
        } else {
            return ['status' => 'error', 'message' => 'Usuario no encontrado'];
        }
    }
    public static function registro($nombre, $correo, $name_user, $paterno, $materno, $password, $estatus) {
        try {
            $sql = "INSERT INTO usuario (nombre, correo, name_user, paterno, materno, password, estatus)
                    VALUES (:nombre, :correo, :name_user, :paterno, :materno, :password, :estatus)";
            $db = self::$database::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":nombre", $nombre);
            $stmt->bindParam(":correo", $correo);
            $stmt->bindParam(":name_user", $name_user);
            $stmt->bindParam(":paterno", $paterno);
            $stmt->bindParam(":materno", $materno);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":estatus", $estatus);
            $stmt->execute();
            $lastInsertID = $db->lastInsertId();

            self::$respuesta["status"] = "ok";
            self::$respuesta["mensaje"] = "Registro Exitoso";
            self::$respuesta["last_insert_id"] = $lastInsertID;
        } catch (RuntimeException | PDOException $e) {
            self::$respuesta["status"] = "error";
            self::$respuesta["mensaje"] = $e->getMessage();
        }

        return self::$respuesta;
    }

    public static function setRoles($id_usuario, $roles) {

       try {
            // Verificar que $roles sea un arreglo
            if (!is_array($roles)) {
                throw new Exception("El parámetro roles debe ser un arreglo");
            }

            $db = self::$database::getConnection();
            $sql = "INSERT INTO permiso_rol_empleados(id_permiso, id_rol, id_empleado) 
                    VALUES (:id_permiso, :id_rol, :id_empleado)";
            $stmt = $db->prepare($sql);

            // Mapa de permisos a IDs (ajusta según tu tabla de permisos)
            $permisosMap = [
                'Actualizar' => 1,
                'Eliminar' => 2,
                'Crear' => 3
                // Agrega más permisos según tu base de datos
            ];

            // Iterar sobre cada rol
            foreach ($roles as $rol) {
                $id_rol = $rol['id'];
                // Iterar sobre cada permiso del rol
                foreach ($rol['permisos'] as $permiso) {
                    if (!isset($permisosMap[$permiso])) {
                        throw new Exception("Permiso no válido: $permiso");
                    }
                    $id_permiso = $permisosMap[$permiso];

                    // Vincular parámetros
                    $stmt->bindParam(":id_permiso", $id_permiso, PDO::PARAM_INT);
                    $stmt->bindParam(":id_rol", $id_rol, PDO::PARAM_INT);
                    $stmt->bindParam(":id_empleado", $id_usuario, PDO::PARAM_INT);

                    // Ejecutar la consulta
                    $stmt->execute();
                }
            }

            self::$respuesta["status"] = "ok";
            self::$respuesta["mensaje"] = "Permisos asignados correctamente";
        } catch (Exception $e) {
            self::$respuesta["status"] = "error";
            self::$respuesta["mensaje"] = $e->getMessage();
        }

        return self::$respuesta;
    }

    public static function updateUsuario($id, $etapa) {
        try {
            $sql = "UPDATE datos_personales SET etapa = :etapa WHERE id = :id";
            $db = self::$database::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":etapa", $etapa);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            self::$respuesta["status"] = "ok";
            self::$respuesta["mensaje"] = "Exitoso";
        } catch (PDOException $e) {
            self::$respuesta["status"] = "error";
            self::$respuesta["mensaje"] = $e->getMessage();
        }

        return self::$respuesta;
    }
}
