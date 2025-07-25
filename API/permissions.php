<?php
require_once './db/Conection.php';
require_once './pruebas/Consultas.pruebas.php';

require_once './permisos/ControllerPermisos.php';
require_once './permisos/ConsultasPermisos.php';
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