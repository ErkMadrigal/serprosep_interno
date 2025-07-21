<?php 

     class ConsultasPermisos {
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

        public static function getPermiso($id_empleado){
            try{
                $id_empleado = intval($id_empleado);
                $sql = "SELECT e.*, CONCAT(e.nombre, ' ', e.paterno, ' ', e.materno) AS nombreCompleto, mp.valor puesto, mz.valor zona, ms.valor estatus, mb.valor institucionBancaria FROM empleados e LEFT JOIN multicatalogo mz on e.id_zona = mz.id LEFT JOIN multicatalogo mp on e.id_puesto = mp.id LEFT JOIN multicatalogo ms on e.estatus = ms.id LEFT JOIN multicatalogo mb on e.id_banco = mb.id WHERE e.id = :id_empleado";
                
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
    