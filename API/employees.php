<?php
require_once './db/Conection.php';
require_once './pruebas/Consultas.pruebas.php';

require_once './Empleados/ControllerEmpleados.php';
require_once './Empleados/ConsultasEmpleados.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once './methods/method.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-API-KEY");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 3600");

// Manejar preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

define('API_KEY', $_ENV['API_KEY'] ?? '');

// Leer input JSON
$rawInput = file_get_contents("php://input");
$data = json_decode($rawInput, true);

// Validar JSON
if ($data === null || !isset($data['action'])) {
    echo json_encode(["status" => "error", "message" => "JSON inválido o sin acción"], JSON_UNESCAPED_UNICODE);
    exit;
}

$opcion = $data['action'];

// Validar API Key
$apiKey = getApiKey();
if (!$apiKey || $apiKey !== API_KEY) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "API Key inválida o no proporcionada"], JSON_UNESCAPED_UNICODE);
    exit();
}

date_default_timezone_set('America/Mexico_City');

switch ($opcion) {
    case "empleados":
       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jwt = getBearerToken();

            if (!$jwt) {
                http_response_code(401);
                echo json_encode(["status" => "error", "message" => "Token JWT no proporcionado"], JSON_UNESCAPED_UNICODE);
                exit();
            }

            try {
                $decoded = JWT::decode($jwt, new Key($_ENV['JWT_SECRET'], 'HS256'));

                // Campos requeridos
                $clave_interbancaria = $data['clave_interbancaria'] ?? false;
                $id_banco            = $data['id_banco']            ?? false;

                $paterno             = $data['paterno']             ?? false;
                $materno             = $data['materno']             ?? false;
                $nombre              = $data['nombre']              ?? false;
                $curp                = $data['curp']                ?? false;
                $rfc                 = $data['rfc']                 ?? false;
                $nss                 = $data['nss']                 ?? false;

                // Campos opcionales
                $no_empleado         = $data['no_empleado']         ?? '';
                $id_unidad_negocio   = $data['id_unidad_negocio']   ?? '';
                $id_regional         = $data['id_regional']         ?? '';
                $id_zona             = $data['id_zona']             ?? '';
                $id_empresa          = $data['id_empresa']          ?? '';
                $id_servicio         = $data['id_servicio']         ?? '';
                $id_turno            = $data['id_turno']            ?? '';
                $id_puesto           = $data['id_puesto']           ?? '';
                $sueldo              = $data['sueldo']              ?? '';
                $id_periocidad       = $data['id_periocidad']       ?? '';
                $cuenta              = $data['cuenta']              ?? '';
                $estatus             = 1; // o lo que aplique
                $fecha_ingreso       = date('Y-m-d'); // Fecha actual

                
                // Validación de campos obligatorios
                $camposRequeridos = [
                    $clave_interbancaria, $id_banco,
                    $paterno, $materno, $nombre,
                    $curp, $rfc, $nss
                ];

                if (in_array(false, $camposRequeridos, true)) {
                    echo json_encode([
                        "status" => "error",
                        "message" => "Todos los campos obligatorios deben ser proporcionados"
                    ], JSON_UNESCAPED_UNICODE);
                }else {
                    $id = isset($data['id']) ? trim($data['id']) : '';
                    $empleados = new ControllerEmpleados();
                    if($id === '' ){
                        echo json_encode(
                            $empleados::registro(
                                $no_empleado, $id_unidad_negocio, $id_regional, $id_zona,
                                $id_empresa, $id_servicio, $curp, $rfc, $nss, $fecha_ingreso,
                                $paterno, $materno, $nombre, $id_turno, $id_puesto, $sueldo,
                                $id_periocidad, $cuenta, $clave_interbancaria, $id_banco, $estatus
                            ),
                            JSON_UNESCAPED_UNICODE
                        );
                    }else{
                        echo json_encode(
                            $empleados::actualizar(
                                intval($id), $no_empleado, $id_unidad_negocio, $id_regional, $id_zona,
                                $id_empresa, $id_servicio, $curp, $rfc, $nss, $fecha_ingreso,
                                $paterno, $materno, $nombre, $id_turno, $id_puesto, $sueldo,
                                $id_periocidad, $cuenta, $clave_interbancaria, $id_banco, $estatus
                            ),
                            JSON_UNESCAPED_UNICODE
                        );
                    }
                }
            } catch (Exception $e) {
                http_response_code(401);
                echo json_encode(["status" => "error", "message" => "Token JWT inválido: " . $e->getMessage()], JSON_UNESCAPED_UNICODE);
                exit();
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Método no permitido"], JSON_UNESCAPED_UNICODE);
        }

        break;

    case "getEmpleados":
       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jwt = getBearerToken();

            if (!$jwt) {
                http_response_code(401);
                echo json_encode(["status" => "error", "message" => "Token JWT no proporcionado"], JSON_UNESCAPED_UNICODE);
                exit();
            }

            try {
                $decoded = JWT::decode($jwt, new Key($_ENV['JWT_SECRET'], 'HS256'));

                // Campos requeridos
                    $empleados = new ConsultasEmpleados();
                    $data['limit'] = $data['limit'] ?? 50; // Valor por defecto si no se proporciona
                    echo json_encode(
                        $empleados::getEmpleados($data['limit']), JSON_UNESCAPED_UNICODE
                    );
            } catch (Exception $e) {
                http_response_code(401);
                echo json_encode(["status" => "error", "message" => "Token JWT inválido: " . $e->getMessage()], JSON_UNESCAPED_UNICODE);
                exit();
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Método no permitido"], JSON_UNESCAPED_UNICODE);
        }

        break;

    case "getEmpleado":
       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jwt = getBearerToken();

            if (!$jwt) {
                http_response_code(401);
                echo json_encode(["status" => "error", "message" => "Token JWT no proporcionado"], JSON_UNESCAPED_UNICODE);
                exit();
            }

            try {
                $decoded = JWT::decode($jwt, new Key($_ENV['JWT_SECRET'], 'HS256'));

                // Campos requeridos
                    $empleados = new ConsultasEmpleados();
                    echo json_encode(
                        $empleados::getEmpleado($data['id_empleado']), JSON_UNESCAPED_UNICODE
                    );
            } catch (Exception $e) {
                http_response_code(401);
                echo json_encode(["status" => "error", "message" => "Token JWT inválido: " . $e->getMessage()], JSON_UNESCAPED_UNICODE);
                exit();
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Método no permitido"], JSON_UNESCAPED_UNICODE);
        }

        break;

    default:
        echo json_encode(["status" => "error", "message" => "Acción no reconocida"], JSON_UNESCAPED_UNICODE);
        break;
}
