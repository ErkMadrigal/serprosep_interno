<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


// Clave JWT directa
$JWT_SECRET = 'zT9wU!5vYp@34Fk'; // <- cambia a tu clave segura

/**
 * Verifica si un token JWT es válido.
 */
function verificarToken($token) {
    global $JWT_SECRET;
    if (!$token) return false;

    try {
        JWT::decode($token, new Key($JWT_SECRET, 'HS256'));
        return true;
    } catch (Exception $e) {
        error_log("Error JWT: " . $e->getMessage());
        return false;
    }
}

/**
 * Devuelve el payload decodificado del JWT.
 */
function obtenerDatosToken($token) {
    global $JWT_SECRET;
    if (!$token) return null;

    try {
        return JWT::decode($token, new Key($JWT_SECRET, 'HS256'));
    } catch (Exception $e) {
        error_log("Error decodificando JWT: " . $e->getMessage());
        return null;
    }
}
