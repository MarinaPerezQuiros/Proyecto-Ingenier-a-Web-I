<?php
/**
 * Configuración de la base de datos
 * FarmAdviseD - Proyecto Ingeniería Web
 */

// Configuración de conexión
define('DB_HOST', 'localhost:3307');  // Cambiar a localhost:3306 si usas puerto por defecto
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'farmadvised_db');

// Conexión a la base de datos
function getConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die(json_encode([
            'success' => false,
            'message' => 'Error de conexión a la base de datos'
        ]));
    }
    
    $conn->set_charset('utf8mb4');
    return $conn;
}

// Función para sanitizar entradas
function sanitizar($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Configurar headers para JSON
function setJsonHeaders() {
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
}
?>
