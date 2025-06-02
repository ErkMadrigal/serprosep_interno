<?php
$request = $_SERVER['REQUEST_URI'];
$basePath = '/serprosep_interno/API'; // ajusta si cambia

// Eliminar parámetros GET y la base
$uri = str_replace($basePath, '', parse_url($request, PHP_URL_PATH));
$uri = trim($uri, '/'); // ejemplo: "empleados"

// Ruta esperada
$ruta = __DIR__ . '/' . $uri . '.php';

if (file_exists($ruta)) {
    require $ruta;
    exit;
} else {
    http_response_code(404);
    echo json_encode(["error" => "Ruta no encontrada"]);
    exit;
}
