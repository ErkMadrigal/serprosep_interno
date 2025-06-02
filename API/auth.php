<?php
require_once './db/Conection.php';
require_once './pruebas/Consultas.pruebas.php';

require_once './usuarios/ControllerUsuarios.php';
require_once './usuarios/ConsultasUsuarios.php';
require_once __DIR__ . '/vendor/autoload.php';

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

// Función para obtener todos los headers normalizados en minúsculas
function getAllHeadersNormalized() {
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
    // Normalizar claves a minúsculas
    $normalized = [];
    foreach ($headers as $k => $v) {
        $normalized[strtolower($k)] = $v;
    }
    return $normalized;
}

// Función para obtener API Key desde header X-API-KEY
function getApiKey() {
    $headers = getAllHeadersNormalized();
    return $headers['x-api-key'] ?? null;
}

// Función para obtener Bearer token desde header Authorization
function getBearerToken() {
    $headers = getAllHeadersNormalized();
    if (isset($headers['authorization']) && preg_match('/Bearer\s(\S+)/', $headers['authorization'], $matches)) {
        return $matches[1];
    }
    return null;
}

// Leer input JSON
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
if ($opcion !== 'pruebaVida' && $data === null) {
    echo json_encode(["status" => "error", "message" => "JSON inválido"], JSON_UNESCAPED_UNICODE);
    exit;
}

// Validar API Key SOLO si la acción NO es pruebaVida
if ($opcion !== 'pruebaVida') {
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

            if (in_array(false, [$nombre, $paterno, $materno, $name_user, $correo, $password], true)) {
                echo json_encode(["status" => "error", "message" => "Todos los campos son requeridos"], JSON_UNESCAPED_UNICODE);
            } else {
                $consultas = new ConsultasUsuarios();
                $existingUser = $consultas::getUsr($name_user);
                if ($existingUser['status'] === 'ok' && !empty($existingUser['data'])) {
                    echo json_encode(["status" => "error", "message" => "El nombre de usuario ya está registrado"], JSON_UNESCAPED_UNICODE);
                    exit;
                }
                $existingCorreo = $consultas::getCorreo($correo);
                if ($existingCorreo['status'] === 'ok' && !empty($existingCorreo['data'])) {
                    echo json_encode(["status" => "error", "message" => "El correo ya está registrado"], JSON_UNESCAPED_UNICODE);
                    exit;
                }

                $empleados = new ControllerUsuarios();
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
                $empleados = new ControllerUsuarios();
                $respuesta = $empleados::login($name_user, $password);

                echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Usuario y contraseña son requeridos"
                ], JSON_UNESCAPED_UNICODE);
            }
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Método no permitido"
            ], JSON_UNESCAPED_UNICODE);
        }
        break;

    case "info":
        $jwt = getBearerToken();

        if (!$jwt) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Token JWT no proporcionado"], JSON_UNESCAPED_UNICODE);
            exit();
        }

        try {
            $decoded = JWT::decode($jwt, new Key($_ENV['JWT_SECRET'], 'HS256'));

            echo json_encode([
                "status" => "ok",
                "message" => "Acceso autorizado",
                "user" => $decoded->data
            ], JSON_UNESCAPED_UNICODE);

        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Token JWT inválido: " . $e->getMessage()], JSON_UNESCAPED_UNICODE);
            exit();
        }
        break;

        case "refreshToken":
            $jwt = getBearerToken();

            if (!$jwt) {
                http_response_code(401);
                echo json_encode(["status" => "error", "message" => "Token JWT no proporcionado"], JSON_UNESCAPED_UNICODE);
                exit();
            }

            try {
                $decoded = JWT::decode($jwt, new Key($_ENV['JWT_SECRET'], 'HS256'));

                // Aquí puedes definir cuánto tiempo quieres que dure el nuevo token (por ejemplo, 1 hora)
                $issuedAt   = time();
                $expiration = $issuedAt + 3600; // 1 hora

                $newPayload = [
                    'iat'  => $issuedAt,
                    'exp'  => $expiration,
                    'data' => $decoded->data // Reutilizamos los datos del token anterior
                ];

                $newJwt = JWT::encode($newPayload, $_ENV['JWT_SECRET'], 'HS256');

                echo json_encode([
                    "status" => "ok",
                    "message" => "Token refrescado",
                    "token" => $newJwt
                ], JSON_UNESCAPED_UNICODE);

            } catch (Exception $e) {
                http_response_code(401);
                echo json_encode(["status" => "error", "message" => "Token JWT inválido: " . $e->getMessage()], JSON_UNESCAPED_UNICODE);
                exit();
            }
            break;


    default:
        echo json_encode(["status" => "error", "message" => "Acción no reconocida"], JSON_UNESCAPED_UNICODE);
        break;
}
