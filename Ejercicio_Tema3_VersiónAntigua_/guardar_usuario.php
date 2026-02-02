<?php
// guardar_usuario.php - Guarda nombre y email en MySQL

// Configuración de la base de datos
$servidor = "localhost:3307";
$usuario_db = "root";
$password_db = "";
$nombre_db = "ejercicios";

// Variables para mensajes
$exito = false;
$mensaje = "";

// Verificar que se recibieron datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Obtener datos del formulario
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    
    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($email)) {
        $mensaje = "Error: Todos los campos son obligatorios.";
    } else {
        // Crear conexión a MySQL
        $conexion = new mysqli($servidor, $usuario_db, $password_db, $nombre_db);
        
        // Verificar conexión
        if ($conexion->connect_error) {
            $mensaje = "Error de conexión: " . $conexion->connect_error;
        } else {
            // Preparar consulta SQL (usando prepared statements para seguridad)
            $sql = "INSERT INTO usuarios (nombre, email) VALUES (?, ?)";
            $stmt = $conexion->prepare($sql);
            
            if ($stmt) {
                // Vincular parámetros
                $stmt->bind_param("ss", $nombre, $email);
                
                // Ejecutar consulta
                if ($stmt->execute()) {
                    $exito = true;
                    $mensaje = "Usuario registrado correctamente con ID: " . $conexion->insert_id;
                } else {
                    $mensaje = "Error al insertar: " . $stmt->error;
                }
                
                $stmt->close();
            } else {
                $mensaje = "Error al preparar consulta: " . $conexion->error;
            }
            
            // Cerrar conexión
            $conexion->close();
        }
    }
} else {
    header("Location: formulario_usuarios.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado - Registro</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&family=Bebas+Neue&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier Prime', monospace;
            background: #0d1117;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .resultado {
            background: #f5f0e8;
            border: 5px solid <?php echo $exito ? '#4a9c5d' : '#c94444'; ?>;
            box-shadow: 15px 15px 0 <?php echo $exito ? '#2d6b3a' : '#8b2b2b'; ?>;
            max-width: 450px;
            width: 100%;
            text-align: center;
        }
        
        .cabecera {
            background: <?php echo $exito ? '#4a9c5d' : '#c94444'; ?>;
            padding: 25px;
            border-bottom: 5px solid <?php echo $exito ? '#2d6b3a' : '#8b2b2b'; ?>;
        }
        
        h1 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2rem;
            color: #fff;
            text-transform: uppercase;
        }
        
        .contenido {
            padding: 35px;
        }
        
        .icono {
            font-size: 4rem;
            margin-bottom: 20px;
        }
        
        .mensaje {
            font-size: 1rem;
            padding: 20px;
            background: #fffbf5;
            border: 2px dashed <?php echo $exito ? '#4a9c5d' : '#c94444'; ?>;
            margin-bottom: 25px;
        }
        
        .datos {
            text-align: left;
            background: #1a1a1a;
            color: #f5f0e8;
            padding: 20px;
            margin-bottom: 25px;
        }
        
        .datos p {
            margin-bottom: 8px;
        }
        
        .datos strong {
            color: <?php echo $exito ? '#4a9c5d' : '#c94444'; ?>;
        }
        
        a {
            display: inline-block;
            padding: 15px 30px;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            background: <?php echo $exito ? '#2d6b3a' : '#8b2b2b'; ?>;
            color: #fff;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        
        a:hover {
            background: <?php echo $exito ? '#4a9c5d' : '#c94444'; ?>;
            transform: translate(-2px, -2px);
            box-shadow: 4px 4px 0 #1a1a1a;
        }
    </style>
</head>
<body>
    <div class="resultado">
        <div class="cabecera">
            <h1><?php echo $exito ? 'Registro Exitoso' : 'Error'; ?></h1>
        </div>
        
        <div class="contenido">
            <div class="icono"><?php echo $exito ? '✓' : '✗'; ?></div>
            
            <div class="mensaje">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
            
            <?php if ($exito): ?>
            <div class="datos">
                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            </div>
            <?php endif; ?>
            
            <a href="formulario_usuarios.html">← Volver al formulario</a>
        </div>
    </div>
</body>
</html>
