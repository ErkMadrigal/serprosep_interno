<?php 

     class ConsultasUsuarios{
        private static $database;
        private static $respuesta;
        
        public function __construct(){
            self::$database = new DataBase();
            self::$respuesta = null;
        }
        
        public static function getCorreo($correo){
            try{
                $sql = "SELECT * FROM usuario WHERE correo = :correo";
                
                $dbc = self::$database::getConnection();
                $stmt = $dbc->prepare($sql);
                $stmt->bindParam(":correo", $correo);
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

        public static function getUsr($name_user){
            try{
                $sql = "SELECT * FROM usuario WHERE name_user = :name_user";
                
                $dbc = self::$database::getConnection();
                $stmt = $dbc->prepare($sql);
                $stmt->bindParam(":name_user", $name_user);
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

        public static function getRoles(){
            try{
                $sql = "SELECT * FROM roles";
                
                $dbc = self::$database::getConnection();
                $stmt = $dbc->prepare($sql);
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


        public static function getPermisos($id){
            try{
                $sql = "SELECT * FROM usuario u 
                    LEFT JOIN permiso_rol_empleados pre on pre.id_empleado = u.id
                    LEFT JOIN roles r on r.id = pre.id_rol
                    LEFT JOIN permisos p on p.id = pre.id_permiso WHERE u.id = :id";
                
                $dbc = self::$database::getConnection();
                $stmt = $dbc->prepare($sql);
                $stmt->bindParam(":id", $id);
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

         public static function getColaboradores($id){
            try{
                $sql = "SELECT concat(nombre, ' ', paterno, ' ', materno), name_user, correo, estatus FROM usuario u WHERE u.id = :id";
                
                $dbc = self::$database::getConnection();
                $stmt = $dbc->prepare($sql);
                $stmt->bindParam(":id", $id);
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
        
        
    }
    