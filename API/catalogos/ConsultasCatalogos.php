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

        
    }
    