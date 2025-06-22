<?php


class ControllerCatalogos {
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
