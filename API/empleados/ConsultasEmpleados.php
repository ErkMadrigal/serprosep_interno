<?php 

     class ConsultasEmpleados{
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
        
        public static function getEmpleados($LIMIT = 50){
            try{
                $LIMIT = intval($LIMIT);
                $sql = "SELECT * FROM empleados LIMIT $LIMIT";
                
                $dbc = self::$database::getConnection();
                $stmt = $dbc->prepare($sql);
                $stmt->execute();
                $data = $stmt->fetch(PDO::FETCH_ASSOC);  
                self::$respuesta["status"] = "ok";
                self::$respuesta["data"] = $data;
            }catch(PDOException $e){
                self::$respuesta["status"] = "error";
                self::$respuesta["data"] = [];
                self::$respuesta["mensaje"] = $e->getMessage();
            }
            return self::$respuesta;
        }

        public static function getEmpleado($id_empleado){
            try{
                $id_empleado = intval($id_empleado);
                $sql = "SELECT * FROM empleados WHERE id = :id_empleado";
                
                $dbc = self::$database::getConnection();
                $stmt = $dbc->prepare($sql);
                $stmt->bindParam(":id_empleado", $id_empleado, PDO::PARAM_INT);
                $stmt->execute();
                $data = $stmt->fetch(PDO::FETCH_ASSOC);  
                
                if($data){
                    self::$respuesta["status"] = "ok";
                    self::$respuesta["data"] = $data;
                }else{
                    self::$respuesta["status"] = "error";
                    self::$respuesta["mensaje"] = "Empleado no encontrado";
                    self::$respuesta["data"] = [];
                }
            }catch(PDOException $e){
                self::$respuesta["status"] = "error";
                self::$respuesta["data"] = [];
                self::$respuesta["mensaje"] = $e->getMessage();
            }
            return self::$respuesta;
        }

        
    }
    