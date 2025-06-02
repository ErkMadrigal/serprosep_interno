<?php
require_once './methods/env.php'; // carga el archivo env.php
loadEnv('./.env'); // carga las variables del archivo .env
require_once './db/Conection.php';
require_once './pruebas/Consultas.pruebas.php';
require_once './empleados/ControllerEmpleados.php';

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

// Leer el contenido bruto de la petición
$rawInput = file_get_contents("php://input");

$data = null;
$opcionTemp = null;

if (!empty($rawInput)) {
    $data = json_decode($rawInput, true);
    if ($data !== null && isset($data['action'])) {
        $opcionTemp = $data['action'];
    }
}

$opcion = $opcionTemp ?? 'pruebaVida';

// Validar JSON sólo si NO es pruebaVida
if ($opcion !== 'pruebaVida') {
    if ($data === null) {
        echo json_encode(["status" => "error", "message" => "JSON inválido"], JSON_UNESCAPED_UNICODE);
        exit;
    }
}

// Validar API Key SOLO si la acción NO es pruebaVida
if ($opcion !== 'pruebaVida') {
    define('API_KEY', getenv('API_KEY'));

    function getApiKey() {
        function normalizeHeaders($headers) {
            $normalized = [];
            foreach ($headers as $key => $value) {
                $normalized[strtolower($key)] = $value;
            }
            return $normalized;
        }

        $headers = [];
        if (function_exists('getallheaders')) {
            $headers = getallheaders();
        } elseif (function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
        } else {
            foreach ($_SERVER as $key => $value) {
                if (strpos($key, 'HTTP_') === 0) {
                    $header = str_replace('_', '-', strtolower(substr($key, 5)));
                    $headers[$header] = $value;
                }
            }
        }
        $headers = normalizeHeaders($headers);

        if (isset($headers['authorization']) && stripos($headers['authorization'], 'Bearer ') === 0) {
            return substr($headers['authorization'], 7);
        }

        if (isset($headers['x-api-key'])) {
            return $headers['x-api-key'];
        }

        return null;
    }

    $apiKey = getApiKey();
    if (!$apiKey || $apiKey !== API_KEY) {
        http_response_code(401);
        echo json_encode(["status" => "error", "message" => "API Key inválida o no proporcionada"], JSON_UNESCAPED_UNICODE);
        exit();
    }
}

date_default_timezone_set('America/Mexico_City');

switch ($opcion) {
    case "pruebaVida":
            $consultas = new Consultas();
            echo json_encode([
                "status" => "ok",
                "message" => "Conexión exitosa",
                "data" => $consultas::prueba()
            ], JSON_UNESCAPED_UNICODE);
        break;

    case "registro":
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre     = $data['nombre']     ?? false;
            $paterno    = $data['paterno']    ?? false;
            $materno    = $data['materno']    ?? false;
            $name_user  = $data['name_user']  ?? false;
            $correo     = $data['correo']     ?? false;
            $password   = isset($data['password']) ? password_hash($data['password'], PASSWORD_ARGON2ID) : false;
            $estatus    = 1;
            $id_rol     = 1;

            if (in_array(false, [$nombre, $paterno, $materno, $name_user, $correo, $password])) {
                echo json_encode(["status" => "error", "message" => "Todos los campos son requeridos"], JSON_UNESCAPED_UNICODE);
            } else {
                $empleados = new ControllerEmpleados();
                echo json_encode($empleados::registro($nombre, $correo, $name_user, $paterno, $materno, $password, $estatus, $id_rol), JSON_UNESCAPED_UNICODE);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Método no permitido"], JSON_UNESCAPED_UNICODE);
        }
        break;

    case "login":
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name_user = $data['name_user'] ?? false;
            $password  = $data['password']  ?? false;

            if ($name_user && $password) {
                $empleados = new ControllerEmpleados();
                echo json_encode($empleados::login($name_user, $password), JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(["status" => "error", "message" => "Usuario y contraseña son requeridos"], JSON_UNESCAPED_UNICODE);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Método no permitido"], JSON_UNESCAPED_UNICODE);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Acción no reconocida"], JSON_UNESCAPED_UNICODE);
        break;
}
