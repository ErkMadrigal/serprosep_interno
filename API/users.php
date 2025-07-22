<?php
require_once './db/Conection.php';

require_once './usuarios/ControllerUsuarios.php';
require_once './usuarios/ConsultasUsuarios.php';
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
    echo json_encode(["status" => "error", "mensaje" => "JSON inválido o sin acción"], JSON_UNESCAPED_UNICODE);
    exit;
}

$opcion = $data['action'];

// Validar API Key
$apiKey = getApiKey();
if (!$apiKey || $apiKey !== API_KEY) {
    http_response_code(401);
    echo json_encode(["status" => "error", "mensaje" => "API Key inválida o no proporcionada"], JSON_UNESCAPED_UNICODE);
    exit();
}

date_default_timezone_set('America/Mexico_City');

switch ($opcion) {
    case "getRoles":
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jwt = getBearerToken();

            if (!$jwt) {
                http_response_code(401);
                echo json_encode(["status" => "error", "mensaje" => "Token JWT no proporcionado"], JSON_UNESCAPED_UNICODE);
                exit();
            }

            try {
                $decoded = JWT::decode($jwt, new Key($_ENV['JWT_SECRET'], 'HS256'));

                // Campos requeridos
                $usuario = new ConsultasUsuarios();
                echo json_encode(
                    $usuario::getRoles(), JSON_UNESCAPED_UNICODE
                );
            } catch (Exception $e) {
                http_response_code(401);
                
                echo json_encode(["status" => "error", "mensaje" => "Token JWT inválido: " . $e->getmensaje()], JSON_UNESCAPED_UNICODE);
                exit();
            }
        } else {
            echo json_encode(["status" => "error", "mensaje" => "Método no permitido"], JSON_UNESCAPED_UNICODE);
            exit();
        }
        break;
    case "newUser":
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jwt = getBearerToken();

            if (!$jwt) {
                http_response_code(401);
                echo json_encode(["status" => "error", "mensaje" => "Token JWT no proporcionado"], JSON_UNESCAPED_UNICODE);
                exit();
            }
            try {
                $decoded = JWT::decode($jwt, new Key($_ENV['JWT_SECRET'], 'HS256'));    
                // Campos requeridos

                $password = random_int(100000, 999999);
                
                $user_name = generateUsername($data['nombre'], $data['paterno'], $data['materno']);

                $consultas = new ConsultasUsuarios();
                $existingUser = $consultas::getUsr($user_name);
                if ($existingUser['status'] === 'ok' && !empty($existingUser['data'])) {
                    echo json_encode(["status" => "error", "mensaje" => "El nombre de usuario ya está registrado"], JSON_UNESCAPED_UNICODE);
                    exit;
                }
                $existingCorreo = $consultas::getCorreo( $data['correo'] );
                if ($existingCorreo['status'] === 'ok' && !empty($existingCorreo['data'])) {
                    echo json_encode(["status" => "error", "mensaje" => "El correo ya está registrado"], JSON_UNESCAPED_UNICODE);
                    exit;
                }

                $usuario = new ControllerUsuarios();
                $data = $usuario::registro($data['nombre'], $data['correo'], $user_name, $data['paterno'], $data['materno'], password_hash($password, PASSWORD_ARGON2ID), 1);
                $data['password'] = $password;
                $data['userName'] = $user_name;
                
                echo json_encode(
                    $data, JSON_UNESCAPED_UNICODE
                );

            } catch (Exception $e) {
                http_response_code(401);
                
                echo json_encode(["status" => "error", "mensaje" => "Token JWT inválido: " . $e->getmensaje()], JSON_UNESCAPED_UNICODE);
                exit();
            }
        }else{
            echo json_encode(["status" => "error", "mensaje" => "Método no permitido"], JSON_UNESCAPED_UNICODE);
            exit();
        }
        break;
    case "setRoles":
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jwt = getBearerToken();


            if (!$jwt) {
                http_response_code(401);
                echo json_encode(["status" => "error", "mensaje" => "Token JWT no proporcionado"], JSON_UNESCAPED_UNICODE);
                exit();
            }
            try {
                $decoded = JWT::decode($jwt, new Key($_ENV['JWT_SECRET'], 'HS256'));
                // Campos requeridos
                $id_usuario = $data['id_usuario'] ?? false; 
                $roles = $data['roles'] ?? false; 
                if ($id_usuario && $roles) {
                    $usuario = new ControllerUsuarios();
                    echo json_encode(
                        $usuario::setRoles($id_usuario, $roles), JSON_UNESCAPED_UNICODE
                    );
                } else {
                    echo json_encode(["status" => "error", "mensaje" => "ID de usuario y rol son requeridos"], JSON_UNESCAPED_UNICODE);
                }   
            } catch (Exception $e) {
                http_response_code(401);
                echo json_encode(["status" => "error", "mensaje" => "Token JWT inválido: " . $e->getmensaje()], JSON_UNESCAPED_UNICODE);
                exit();
            }
        } else {
            echo json_encode(["status" => "error", "mensaje" => "Método no permitido"], JSON_UNESCAPED_UNICODE);
            exit();
        }   
        break;
    default:
        echo json_encode(["status" => "error", "mensaje" => "Acción no reconocida"], JSON_UNESCAPED_UNICODE);
        break;
}

function generateUsername($firstName, $paternalSurname, $maternalSurname) {
    // Limpiar y normalizar los datos de entrada
    $firstName = strtolower(trim($firstName));
    $paternalSurname = strtolower(trim($paternalSurname));
    $maternalSurname = strtolower(trim($maternalSurname));
    
    // Remover acentos y caracteres especiales
    $firstName = iconv('UTF-8', 'ASCII//TRANSLIT', $firstName);
    $paternalSurname = iconv('UTF-8', 'ASCII//TRANSLIT', $paternalSurname);
    $maternalSurname = iconv('UTF-8', 'ASCII//TRANSLIT', $maternalSurname);
    
    // Generar el nombre de usuario en el formato e.madrigal.f
    $username = substr($firstName, 0, 1) . '.' . 
                $paternalSurname . '.' . 
                substr($maternalSurname, 0, 1);
    
    return $username;
}