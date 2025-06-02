<?php 

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function verificarToken() {
    $headers = getallheaders();
    if (!isset($headers['Authorization'])) {
        return false;
    }

    $authHeader = $headers['Authorization'];
    if (strpos($authHeader, 'Bearer ') !== 0) {
        return false;
    }

    $jwt = substr($authHeader, 7);

    try {
        $decoded = JWT::decode($jwt, new Key($_ENV['JWT_SECRET'], 'HS256'));
        return $decoded;
    } catch (Exception $e) {
        return false;
    }
}
