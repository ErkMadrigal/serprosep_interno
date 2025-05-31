<?php 
    class DataBase{
        private static $host = "localhost";
        private static $user = "root";
        private static $password = "";
        private static $name = "samsung_wally_bespoke";



        // private static $host = "localhost";
        // private static $user = "DAPromo";
        // private static $password = "1020@Ch31l";
        // private static $name = "samsung_wally_bespoke";

        public static function getConnection(){
            try {
                $dbc = new PDO("mysql:host=".self::$host.";dbname=".self::$name,self::$user,self::$password);
                return $dbc;
            } catch (PDOException $e) {
                echo "Error de conexión: " . $e->getMessage();
                return null; // O maneja el error de otra manera según tus necesidades
            }
        }

    }