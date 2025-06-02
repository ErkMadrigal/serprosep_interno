<?php
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
    return $headers['x-api-key'] ?? false;
}

// Función para obtener Bearer token desde header Authorization
function getBearerToken() {
    $headers = getAllHeadersNormalized();
    if (isset($headers['authorization']) && preg_match('/Bearer\s(\S+)/', $headers['authorization'], $matches)) {
        return $matches[1];
    }
    return null;
}
