<?php 

     class ConsultasCatalogos{
        private static $database;
        private static $respuesta;
        
        public function __construct(){
            self::$database = new DataBase();
            self::$respuesta = null;
        }
        public function __destruct(){
            self::$database = null;
            self::$respuesta = null;
        }

        public static function getCatalogo($id_catalogo){
            try{
                $sql = "select m.id, m.valor, m.descripcion, c.descripcion catalogo from multicatalogo m LEFT JOIN catalogo c on m.id_catalogo = c.id where c.id = :id";
                
                $dbc = self::$database::getConnection();
                $stmt = $dbc->prepare($sql);
                $stmt->bindParam(":id", $id_catalogo);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                self::$respuesta["status"] = "ok";
                self::$respuesta["data"] = $data;
            }catch(PDOException $e){
                self::$respuesta["status"] = "error";
                self::$respuesta["data"] = [];
                self::$respuesta["mensaje"] = $e->getMessage();
            }
            return self::$respuesta;
        }

        public static function getCatalogoName($id_catalogo, $name) {
            try {
                $sql = "SELECT m.id, m.valor, m.descripcion, c.descripcion AS catalogo 
                        FROM multicatalogo m 
                        LEFT JOIN catalogo c ON m.id_catalogo = c.id 
                        WHERE c.id = :id_catalogo AND m.valor LIKE :name";

                $dbc = self::$database::getConnection();
                $stmt = $dbc->prepare($sql);

                // Vinculación de parámetros
                $stmt->bindParam(":id_catalogo", $id_catalogo, PDO::PARAM_INT);
                $likeName = "%" . $name . "%";
                $stmt->bindParam(":name", $likeName, PDO::PARAM_STR);

                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                self::$respuesta["status"] = "ok";
                self::$respuesta["data"] = $data;

            } catch (PDOException $e) {
                self::$respuesta["status"] = "error";
                self::$respuesta["data"] = [];
                self::$respuesta["mensaje"] = $e->getMessage();
            }

            return self::$respuesta;
        }

        public static function getInstitucionBancaria($clabe) {
            try {
                $sql = "SELECT m.id, m.valor, m.descripcion, c.descripcion AS catalogo 
                        FROM multicatalogo m 
                        LEFT JOIN catalogo c ON m.id_catalogo = c.id 
                        WHERE c.id = 15 AND m.descripcion = :clabe";

                $dbc = self::$database::getConnection();
                $stmt = $dbc->prepare($sql);

                $stmt->bindParam(":clabe", $clabe, PDO::PARAM_STR);
                $stmt->execute();
                $data = $stmt->fetch(PDO::FETCH_ASSOC);

                self::$respuesta["status"] = "ok";
                self::$respuesta["data"] = $data;

            } catch (PDOException $e) {
                self::$respuesta["status"] = "error";
                self::$respuesta["data"] = [];
                self::$respuesta["mensaje"] = $e->getMessage();
            }

            return self::$respuesta;
        }

        public static function getRegionales() {
            try {
                $sql = "SELECT e.id, CONCAT(e.nombre, ' ', e.paterno, ' ', e.materno) valor  FROM regional r LEFT JOIN empleados e on r.id_empleado = e.id ";

                $dbc = self::$database::getConnection();
                $stmt = $dbc->prepare($sql);

                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                self::$respuesta["status"] = "ok";
                self::$respuesta["data"] = $data;

            } catch (PDOException $e) {
                self::$respuesta["status"] = "error";
                self::$respuesta["data"] = [];
                self::$respuesta["mensaje"] = $e->getMessage();
            }

            return self::$respuesta;
        }

        public static function getTipoCatalogos() {
            try {
                $sql = "SELECT *  FROM catalogo";

                $dbc = self::$database::getConnection();
                $stmt = $dbc->prepare($sql);

                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                self::$respuesta["status"] = "ok";
                self::$respuesta["data"] = $data;

            } catch (PDOException $e) {
                self::$respuesta["status"] = "error";
                self::$respuesta["data"] = [];
                self::$respuesta["mensaje"] = $e->getMessage();
            }

            return self::$respuesta;
        }

        public static function getCatalogosSelect($id_catalogo) {
            try {
                $sql = "SELECT m.valor, m.descripcion, c.descripcion catalogo FROM multicatalogo m
                    LEFT JOIN catalogo c on c.id = m.id_catalogo WHERE c.id = :id_catalogo";

                $dbc = self::$database::getConnection();
                $stmt = $dbc->prepare($sql);
                $stmt->bindParam(":id_catalogo", $id_catalogo, PDO::PARAM_STR);

                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                self::$respuesta["status"] = "ok";
                self::$respuesta["data"] = $data;

            } catch (PDOException $e) {
                self::$respuesta["status"] = "error";
                self::$respuesta["data"] = [];
                self::$respuesta["mensaje"] = $e->getMessage();
            }

            return self::$respuesta;
        }
        
    }
    