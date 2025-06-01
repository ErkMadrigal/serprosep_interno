<?php



    class ControllerEmpleados{
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

        public static function login($name_user, $password) {
            try {
                $sql = "SELECT * FROM usuario WHERE name_user = :name_user AND estatus = 1";
                $db = self::$database::getConnection();
                $stmt = $db->prepare($sql);
                $stmt->bindParam(":name_user", $name_user);
                $stmt->execute();
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($usuario && password_verify($password, $usuario['password'])) {
                    self::$respuesta["status"] = "ok";
                    self::$respuesta["mensaje"] = "Login exitoso";
                    self::$respuesta["usuario"] = [
                        "id"        => $usuario["id"],
                        "correo"    => $usuario["correo"],
                        "name_user" => $usuario["name_user"],
                        "id_rol"    => $usuario["id_rol"],
                    ];
                } else {
                    self::$respuesta["status"] = "error";
                    self::$respuesta["mensaje"] = "Credenciales inválidas";
                }

            } catch (PDOException $e) {
                self::$respuesta["status"] = "error";
                self::$respuesta["mensaje"] = $e->getMessage();
            }

            return self::$respuesta;
        }


        public static function registro($nombre, $correo, $name_user, $paterno, $materno, $password, $estatus, $id_rol){
            try{
                
                $sql = "INSERT INTO usuario ( nombre, correo, name_user, paterno, materno, password, estatus, id_rol) values(:nombre, :correo, :name_user, :paterno, :materno, :password, :estatus, :id_rol)";
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
                
            } catch (RuntimeException $e) {
                self::$respuesta["status"] = "error";
                self::$respuesta["mensaje"] = $e->getMessage();
            }catch(PDOException $e){
                self::$respuesta["status"] = "error";
                self::$respuesta["mensaje"] = $e->getMessage();
            }
            return self::$respuesta;
            
        }

        
        public static function updateUsuario($id, $etapa){
            try{
                $sql = "UPDATE datos_personales SET etapa = :etapa where id = :id";
                $db = self::$database::getConnection();
                $stmt = $db->prepare($sql);
                $stmt->bindParam(":etapa", $etapa);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                self::$respuesta["status"] = "ok";
                self::$respuesta["mensaje"] = "Exitoso";
            }catch(PDOException $e){
                self::$respuesta["status"] = "error";
                self::$respuesta["mensaje"] = $e->getMessage();
            }
            return self::$respuesta;
        }



    }