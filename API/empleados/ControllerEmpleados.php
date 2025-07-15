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

       
        public static function registro( $no_empleado,$id_unidad_negocio,$id_regional,$id_zona,$id_empresa,$id_servicio,$curp,$rfc,$nss, $cp, $fecha_ingreso,$paterno,$materno,$nombre,$id_turno,$id_puesto,$sueldo,$id_periocidad,$cuenta,$clave_interbancaria,$id_banco,$estatus){
            try{
                
                $sql = "INSERT INTO empleados (no_empleado, id_unidad_negocio, id_regional, id_zona, id_empresa, id_servicio, curp, rfc, nss, CP_fiscal, fecha_ingreso, paterno, materno, nombre, id_turno, id_puesto, sueldo, id_periocidad, cuenta, clave_interbancaria, id_banco, estatus) values(:no_empleado, :id_unidad_negocio, :id_regional, :id_zona, :id_empresa, :id_servicio, :curp, :rfc, :nss, :CP_fiscal, :fecha_ingreso, :paterno, :materno, :nombre, :id_turno, :id_puesto, :sueldo, :id_periocidad, :cuenta, :clave_interbancaria, :id_banco, :estatus)";
                $db = self::$database::getConnection();
                $stmt = $db->prepare($sql);
                $stmt->bindParam(":no_empleado", $no_empleado);
                $stmt->bindParam(":id_unidad_negocio", $id_unidad_negocio);
                $stmt->bindParam(":id_regional", $id_regional);
                $stmt->bindParam(":id_zona", $id_zona);
                $stmt->bindParam(":id_empresa", $id_empresa,); 
                $stmt->bindParam(":id_servicio", $id_servicio); 
                $stmt->bindParam(":curp", $curp); 
                $stmt->bindParam(":rfc", $rfc); 
                $stmt->bindParam(":nss", $nss);
                $stmt->bindParam(":CP_fiscal", $cp); 
                $stmt->bindParam(":fecha_ingreso", $fecha_ingreso); 
                $stmt->bindParam(":paterno", $paterno); 
                $stmt->bindParam(":materno", $materno); 
                $stmt->bindParam(":nombre", $nombre); 
                $stmt->bindParam(":id_turno", $id_turno); 
                $stmt->bindParam(":id_puesto", $id_puesto); 
                $stmt->bindParam(":sueldo", $sueldo); 
                $stmt->bindParam(":id_periocidad", $id_periocidad); 
                $stmt->bindParam(":cuenta", $cuenta); 
                $stmt->bindParam(":clave_interbancaria", $clave_interbancaria); 
                $stmt->bindParam(":id_banco", $id_banco); 
                $stmt->bindParam(":estatus", $estatus);
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

        public static function actualizar( $id, $no_empleado,$id_unidad_negocio,$id_regional,$id_zona,$id_empresa,$id_servicio,$curp,$rfc,$nss, $cp, $fecha_ingreso,$paterno,$materno,$nombre,$id_turno,$id_puesto,$sueldo,$id_periocidad,$cuenta,$clave_interbancaria,$id_banco,$estatus){
            try{
                
                $sql = "UPDATE empleados SET no_empleado = :no_empleado, id_unidad_negocio = :id_unidad_negocio, id_regional = :id_regional, id_zona = :id_zona, id_empresa = :id_empresa, id_servicio = :id_servicio, curp = :curp, rfc = :rfc, nss = :nss, CP_fiscal = :CP_fiscal, fecha_ingreso = :fecha_ingreso, paterno = :paterno, materno = :materno, nombre = :nombre, id_turno = :id_turno, id_puesto = :id_puesto, sueldo = :sueldo, id_periocidad = :id_periocidad, cuenta = :cuenta, clave_interbancaria = :clave_interbancaria, id_banco = :id_banco, estatus = :estatus WHERE id = :id";
                $db = self::$database::getConnection();
                $stmt = $db->prepare($sql);
                $stmt->bindParam(":no_empleado", $no_empleado);
                $stmt->bindParam(":id_unidad_negocio", $id_unidad_negocio);
                $stmt->bindParam(":id_regional", $id_regional);
                $stmt->bindParam(":id_zona", $id_zona);
                $stmt->bindParam(":id_empresa", $id_empresa,); 
                $stmt->bindParam(":id_servicio", $id_servicio); 
                $stmt->bindParam(":curp", $curp); 
                $stmt->bindParam(":rfc", $rfc); 
                $stmt->bindParam(":nss", $nss); 
                $stmt->bindParam(":CP_fiscal", $cp); 
                $stmt->bindParam(":fecha_ingreso", $fecha_ingreso); 
                $stmt->bindParam(":paterno", $paterno); 
                $stmt->bindParam(":materno", $materno); 
                $stmt->bindParam(":nombre", $nombre); 
                $stmt->bindParam(":id_turno", $id_turno); 
                $stmt->bindParam(":id_puesto", $id_puesto); 
                $stmt->bindParam(":sueldo", $sueldo); 
                $stmt->bindParam(":id_periocidad", $id_periocidad); 
                $stmt->bindParam(":cuenta", $cuenta); 
                $stmt->bindParam(":clave_interbancaria", $clave_interbancaria); 
                $stmt->bindParam(":id_banco", $id_banco); 
                $stmt->bindParam(":estatus", $estatus);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                $lastInsertID = $id;

                self::$respuesta["status"] = "ok";
                self::$respuesta["mensaje"] = "Registro Actualizado";
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

        public static function activar( $id, $estatus, $id_motivo, $finiquito, $nota, $fecha_efectiva){
            try{
                
                $sql = "UPDATE empleados SET estatus = :estatus WHERE id = :id";
                $db = self::$database::getConnection();
                $stmt = $db->prepare($sql);
                $stmt->bindParam(":estatus", $estatus);
                $stmt->bindParam(":id", $id);
                $stmt->execute();

                self::$respuesta["status"] = "ok";
                self::$respuesta["mensaje"] = "El empleado ha sido dado de baja correctamente";
                self::baja_confirmada($id, $id_motivo, $finiquito, $nota, $fecha_efectiva);
                
            } catch (RuntimeException $e) {
                self::$respuesta["status"] = "error";
                self::$respuesta["mensaje"] = $e->getMessage();
            }catch(PDOException $e){
                self::$respuesta["status"] = "error";
                self::$respuesta["mensaje"] = $e->getMessage();
            }
            return self::$respuesta;
            
        }

        public static function baja_confirmada( $id_empleado, $id_motivo, $finiquito, $nota, $fecha_efectiva){
            try{
                
                $sql = "INSERT INTO baja_empleado (id_empleado, id_motivo, finiquito, nota, fecha_efectiva) VALUES (:id_empleado, :id_motivo, :finiquito, :nota, :fecha_efectiva)";
                $db = self::$database::getConnection();
                $stmt = $db->prepare($sql);
                $stmt->bindParam(":id_empleado", $id_empleado);
                $stmt->bindParam(":id_motivo", $id_motivo);
                $stmt->bindParam(":finiquito", $finiquito);
                $stmt->bindParam(":nota", $nota);
                $stmt->bindParam(":fecha_efectiva", $fecha_efectiva);
                $stmt->execute();

                self::$respuesta["status"] = "ok";
                self::$respuesta["mensaje"] = "El empleado ha sido dado de baja correctamente";
                
            } catch (RuntimeException $e) {
                self::$respuesta["status"] = "error";
                self::$respuesta["mensaje"] = $e->getMessage();
            }catch(PDOException $e){
                self::$respuesta["status"] = "error";
                self::$respuesta["mensaje"] = $e->getMessage();
            }
            return self::$respuesta;
            
        }


    }