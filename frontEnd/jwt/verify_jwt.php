<?php 

require_once __DIR__ . '/../vendor/autoload.php';


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

function verificarToken($token) {

    try {
        $decoded = JWT::decode($token, new Key($_ENV['JWT_SECRET'], 'HS256'));
        return $decoded; // O true si solo te interesa la validación
    } catch (Exception $e) {
        return false;
    }
}
