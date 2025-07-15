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

    public static function newMultiCatalogo($id_catalogo, $valor, $descripcion) {
        try {
            $sql = "INSERT INTO multicatalogo (descripcion, valor, id_catalogo)
                    VALUES (:descripcion, :valor, :id_catalogo)";
            $db = self::$database::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":descripcion", $descripcion);
            $stmt->bindParam(":valor", $valor);
            $stmt->bindParam(":id_catalogo", $id_catalogo);
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

    public static function newCatalogo($descripcion) {
        try {
            $sql = "INSERT INTO catalogo (descripcion)
                    VALUES (:descripcion)";
            $db = self::$database::getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":descripcion", $descripcion);
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
