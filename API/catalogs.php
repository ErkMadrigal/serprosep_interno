<?php
require_once './db/Conection.php';

require_once './catalogos/ControllerCatalogos.php';
require_once './catalogos/ConsultasCatalogos.php';
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
    case "getCatalogos":
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
                $catalogos = new ConsultasCatalogos();
                echo json_encode(
                    $catalogos::getCatalogo($data['id_catalogo']), JSON_UNESCAPED_UNICODE
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

    case "getCatalogosName":
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
                $catalogos = new ConsultasCatalogos();
                echo json_encode(
                    $catalogos::getCatalogoName($data['id_catalogo'], $data['name']), JSON_UNESCAPED_UNICODE
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
    case "getInstitucionBancaria":
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
                $catalogos = new ConsultasCatalogos();
                echo json_encode(
                    $catalogos::getInstitucionBancaria($data['clabe']), JSON_UNESCAPED_UNICODE
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

    case "getRegionales":   
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
                $catalogos = new ConsultasCatalogos();
                echo json_encode(
                    $catalogos::getRegionales(), JSON_UNESCAPED_UNICODE
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
    case "getTipoCatalogos":

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
                $catalogos = new ConsultasCatalogos();
                echo json_encode(
                    $catalogos::getTipoCatalogos(), JSON_UNESCAPED_UNICODE
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

    case "newCatalogo":

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

                switch ($data['tipo']) {
                    case 'catalogo':
                        $catalogos = new ControllerCatalogos();
                        echo json_encode(
                            $catalogos::newCatalogo($data['descripcion']), JSON_UNESCAPED_UNICODE
                        );
                        break;
                    case 'multicatalogo':
                        $catalogos = new ControllerCatalogos();
                        echo json_encode(
                            $catalogos::newMultiCatalogo($data['id_Catalogo'], $data['valor'], $data['descripcion']), JSON_UNESCAPED_UNICODE
                        );
                        break;
                    default:
                        echo json_encode(["status" => "error", "message" => "Tipo de catalogo no reconocido"], JSON_UNESCAPED_UNICODE);
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
            
    default:
        echo json_encode(["status" => "error", "message" => "Acción no reconocida"], JSON_UNESCAPED_UNICODE);
        break;
}