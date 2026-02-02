<?php
/**
 * API de Categorías
 * Devuelve las categorías en formato JSON para cargar con AJAX
 */

require_once 'config.php';
setJsonHeaders();

// Solo aceptar GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Conectar a la base de datos
$conn = getConnection();

// Obtener todas las categorías
$sql = "SELECT id, nombre, icono FROM categorias ORDER BY nombre ASC";
$result = $conn->query($sql);

$categorias = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categorias[] = [
            'id' => $row['id'],
            'nombre' => htmlspecialchars($row['nombre']),
            'icono' => $row['icono']
        ];
    }
}

echo json_encode([
    'success' => true,
    'categorias' => $categorias
]);

$conn->close();
?>
