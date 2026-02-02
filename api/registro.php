<?php
/**
 * API de Registro de Usuarios
 * Implementa seguridad: password_hash, prepared statements, validación servidor
 */

require_once 'config.php';
setJsonHeaders();

// Solo aceptar POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Obtener y sanitizar datos
$nombre = isset($_POST['nombre']) ? sanitizar($_POST['nombre']) : '';
$email = isset($_POST['email']) ? sanitizar($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validación del lado del servidor
$errores = [];

if (empty($nombre)) {
    $errores[] = 'El nombre es obligatorio';
} elseif (strlen($nombre) < 2) {
    $errores[] = 'El nombre debe tener al menos 2 caracteres';
}

if (empty($email)) {
    $errores[] = 'El email es obligatorio';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores[] = 'El formato del email no es válido';
}

if (empty($password)) {
    $errores[] = 'La contraseña es obligatoria';
} elseif (strlen($password) < 6) {
    $errores[] = 'La contraseña debe tener al menos 6 caracteres';
}

// Si hay errores de validación
if (!empty($errores)) {
    echo json_encode([
        'success' => false,
        'message' => implode('. ', $errores)
    ]);
    exit;
}

// Conectar a la base de datos
$conn = getConnection();

// Verificar si el email ya existe (usando prepared statement)
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Este email ya está registrado'
    ]);
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

// Hashear la contraseña de forma segura
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Insertar usuario (usando prepared statement para evitar SQL injection)
$stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, fecha_registro) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("sss", $nombre, $email, $passwordHash);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => '¡Registro exitoso! Ya puedes iniciar sesión.'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error al registrar usuario. Inténtalo de nuevo.'
    ]);
}

$stmt->close();
$conn->close();
?>
