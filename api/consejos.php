<?php
/**
 * API de Consejos
 * Devuelve consejos en JSON, con opción de filtrar por categoría
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

// Verificar si hay filtro de categoría
$categoriaId = isset($_GET['categoria']) ? intval($_GET['categoria']) : null;

if ($categoriaId) {
    // Consulta con filtro (prepared statement)
    $stmt = $conn->prepare("
        SELECT c.id, c.titulo, c.contenido, cat.nombre as categoria
        FROM consejos c
        INNER JOIN categorias cat ON c.categoria_id = cat.id
        WHERE c.categoria_id = ?
        ORDER BY c.id DESC
    ");
    $stmt->bind_param("i", $categoriaId);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Consulta sin filtro
    $result = $conn->query("
        SELECT c.id, c.titulo, c.contenido, cat.nombre as categoria
        FROM consejos c
        INNER JOIN categorias cat ON c.categoria_id = cat.id
        ORDER BY c.id DESC
    ");
}

$consejos = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $consejos[] = [
            'id' => $row['id'],
            'titulo' => htmlspecialchars($row['titulo']),
            'contenido' => htmlspecialchars($row['contenido']),
            'categoria' => htmlspecialchars($row['categoria'])
        ];
    }
}

echo json_encode([
    'success' => true,
    'consejos' => $consejos
]);

if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?>
