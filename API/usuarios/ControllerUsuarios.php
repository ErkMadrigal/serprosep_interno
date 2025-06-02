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
                    'exp' => time() + 3600,           // Expira en 1 hora
                    'data' => [
                        'id' => $user['id'],
                        'name_user' => $user['name_user'],
                        'correo' => $user['correo'],
                        'rol' => $user['id_rol'],
                    ]
                ];

                $jwt = JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');

                return [
                    'status' => 'ok',
                    'message' => 'Inicio de sesión exitoso',
                    'token' => $jwt,
                    'usuario' => [
                        'id' => $user['id'],
                        'name_user' => $user['name_user'],
                        'correo' => $user['correo'],
                        'rol' => $user['id_rol']
                    ]
                ];
            } else {
                return ['status' => 'error', 'message' => 'Contraseña incorrecta'];
            }
        } else {
            return ['status' => 'error', 'message' => 'Usuario no encontrado'];
        }
    }
    public static function registro($nombre, $correo, $name_user, $paterno, $materno, $password, $estatus, $id_rol) {
        try {
            $sql = "INSERT INTO usuario (nombre, correo, name_user, paterno, materno, password, estatus, id_rol)
                    VALUES (:nombre, :correo, :name_user, :paterno, :materno, :password, :estatus, :id_rol)";
            $db = self::$database::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":nombre", $nombre);
            $stmt->bindParam(":correo", $correo);
            $stmt->bindParam(":name_user", $name_user);
            $stmt->bindParam(":paterno", $paterno);
            $stmt->bindParam(":materno", $materno);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":estatus", $estatus);
            $stmt->bindParam(":id_rol", $id_rol);
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
