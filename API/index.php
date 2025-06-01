<?php

    require_once './db/Conection.php';
    require_once './pruebas/Consultas.pruebas.php';
    require_once './empleados/ControllerEmpleados.php';

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Max-Age: 3600");

    // Manejar preflight request
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit();
    }

    date_default_timezone_set('America/Mexico_City');

    // Obtener cuerpo JSON
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar si el JSON es válido
    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(["status" => "error", "message" => "JSON inválido"]);
        exit;
    }

    // Leer la acción desde JSON o usar por defecto
    $opcion = $data['action'] ?? 'pruebaVida';

    switch ($opcion) {
        case "pruebaVida":
            if ($conn) {
                $consultas = new Consultas();
                echo json_encode([
                    "status" => "ok",
                    "message" => "Conexión exitosa",
                    "data" => $consultas::prueba()
                ]);
            }else {
                echo json_encode(["status" => "error", "message" => "Error de conexión a la base de datos"]);
            }   
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
                    echo json_encode(["status" => "error", "message" => "Todos los campos son requeridos"]);
                } else {
                    $empleados = new ControllerEmpleados();
                    echo json_encode($empleados::registro($nombre, $correo, $name_user, $paterno, $materno, $password, $estatus, $id_rol));
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Método no permitido"]);
            }
            break;

        case "login":
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name_user    = $data['name_user']    ?? false;
                $password = $data['password'] ?? false;

                if ($name_user && $password) {
                    $empleados = new ControllerEmpleados();
                    echo json_encode($empleados::login($name_user, $password));
                } else {
                    echo json_encode(["status" => "error", "message" => "Email y contraseña son requeridos"]);
                }
            }
            break;

        default:
            echo json_encode(["status" => "error", "message" => "Acción no reconocida"]);
            break;
    }
