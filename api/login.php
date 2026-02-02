<?php
/**
 * API de Login
 * Implementa seguridad: password_verify, prepared statements, sesiones
 */

session_start();
require_once 'config.php';
setJsonHeaders();

// Solo aceptar POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Obtener y sanitizar datos
$email = isset($_POST['email']) ? sanitizar($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validación del lado del servidor
if (empty($email) || empty($password)) {
    echo json_encode([
        'success' => false,
        'message' => 'Email y contraseña son obligatorios'
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'El formato del email no es válido'
    ]);
    exit;
}

// Conectar a la base de datos
$conn = getConnection();

// Buscar usuario por email (prepared statement)
$stmt = $conn->prepare("SELECT id, nombre, email, password FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Email o contraseña incorrectos'
    ]);
    $stmt->close();
    $conn->close();
    exit;
}

$usuario = $result->fetch_assoc();
$stmt->close();

// Verificar contraseña con password_verify
if (password_verify($password, $usuario['password'])) {
    // Iniciar sesión
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nombre'] = $usuario['nombre'];
    $_SESSION['usuario_email'] = $usuario['email'];
    
    echo json_encode([
        'success' => true,
        'message' => '¡Bienvenido, ' . htmlspecialchars($usuario['nombre']) . '!',
        'usuario' => [
            'id' => $usuario['id'],
            'nombre' => $usuario['nombre'],
            'email' => $usuario['email']
        ]
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Email o contraseña incorrectos'
    ]);
}

$conn->close();
?>
