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
        
        public static function getEmpleados($limit, $offset){
            try{
                $sql = "SELECT id, concat(nombre, ' ', paterno, ' ', materno) nombre, curp, fecha_ingreso, id_puesto, id_zona, estatus  FROM empleados ORDER BY id DESC LIMIT :limit OFFSET :offset";
                
                $dbc = self::$database::getConnection();
                $stmt = $dbc->prepare($sql);
                $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
                $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
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

        public static function getCountData(){
            try{
                $sql = "SELECT count(*) as empleadosTotales FROM empleados";
                
                $dbc = self::$database::getConnection();
                $stmt = $dbc->prepare($sql);
                $stmt->execute();
                $data = $stmt->fetch(PDO::FETCH_ASSOC);  
                self::$respuesta = $data;
            }catch(PDOException $e){
                self::$respuesta["status"] = "error";
                self::$respuesta["data"] = [];
                self::$respuesta["mensaje"] = $e->getMessage();
            }
            return self::$respuesta;
        }

        public static function getTotalByEstatus($estatus){
            try {
                $sql = "SELECT COUNT(*) as empleadosTotales FROM empleados WHERE estatus = :estatus";

                $dbc = self::$database::getConnection();
                $stmt = $dbc->prepare($sql);
                $stmt->bindParam(':estatus', $estatus, PDO::PARAM_INT);
                $stmt->execute();
                $data = $stmt->fetch(PDO::FETCH_ASSOC);

                return $data;
            } catch (PDOException $e) {
                return [
                    "status" => "error",
                    "data" => [],
                    "mensaje" => $e->getMessage()
                ];
            }
        }

        public static function searchEmpleado($search, $limit, $offset) {
            try {
                $sqlBase = "FROM empleados 
                            WHERE nombre LIKE :termino 
                            OR paterno LIKE :termino 
                            OR materno LIKE :termino 
                            OR curp LIKE :termino 
                            OR rfc LIKE :termino 
                            OR nss LIKE :termino";

                // Consulta de datos
                $sqlSelect = "SELECT id, CONCAT(nombre, ' ', paterno, ' ', materno) AS nombre, curp, fecha_ingreso, id_puesto, id_zona, estatus " . $sqlBase. " LIMIT :limit OFFSET :offset";
                $dbc = self::$database::getConnection();
                $stmt = $dbc->prepare($sqlSelect);
                $like = '%' . $search . '%';
                $stmt->bindParam(':termino', $like, PDO::PARAM_STR);
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Consulta del total
                $sqlCount = "SELECT COUNT(*) AS total " . $sqlBase;
                $stmt = $dbc->prepare($sqlCount);
                $stmt->bindParam(':termino', $like, PDO::PARAM_STR);
                $stmt->execute();
                $total = $stmt->fetch(PDO::FETCH_ASSOC);

                self::$respuesta['status'] = 'ok';
                self::$respuesta['data'] = $data;
                self::$respuesta['total'] = $total['total'];

            } catch (PDOException $e) {
                self::$respuesta["status"] = "error";
                self::$respuesta["data"] = [];
                self::$respuesta["mensaje"] = $e->getMessage();
            }
            return self::$respuesta;
        }

        
    }
    