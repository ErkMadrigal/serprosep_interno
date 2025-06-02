<?php 
require_once __DIR__ . '/../methods/env.php'; // carga el archivo env.php
loadEnv(__DIR__ . '/.env'); // carga las variables del archivo .env

class DataBase {
    private static $host;
    private static $user;
    private static $password;
    private static $name;

    public static function getConnection() {
        // Asignamos desde el .env
        self::$host = getenv('DB_HOST');
        self::$user = getenv('DB_USER');
        self::$password = getenv('DB_PASSWORD');
        self::$name = getenv('DB_NAME');

        try {
            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$name;
            $dbc = new PDO($dsn, self::$user, self::$password);
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbc;
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            return null;
        }
    }
}
