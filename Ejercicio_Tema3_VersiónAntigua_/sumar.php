<?php
// sumar.php - Procesa la suma de dos números recibidos por POST

// Verificar que se recibieron los datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Obtener los números del formulario
    $numero1 = isset($_POST['numero1']) ? floatval($_POST['numero1']) : 0;
    $numero2 = isset($_POST['numero2']) ? floatval($_POST['numero2']) : 0;
    
    // Realizar la suma
    $resultado = $numero1 + $numero2;
    
} else {
    // Si no se accede por POST, redirigir al formulario
    header("Location: formulario_suma.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado - FarmAdviseD</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&family=Bebas+Neue&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier Prime', monospace;
            background: #1a1a1a;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .resultado-box {
            background: #f5f0e8;
            border: 5px solid #5c8a4d;
            box-shadow: 15px 15px 0 #3d5c33;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        
        .cabecera {
            background: #5c8a4d;
            padding: 20px;
            border-bottom: 5px solid #3d5c33;
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
        
        .operacion {
            font-size: 1.2rem;
            margin-bottom: 25px;
            padding: 20px;
            background: #fffbf5;
            border: 2px dashed #5c8a4d;
        }
        
        .numero {
            color: #3d5c33;
            font-weight: bold;
        }
        
        .total {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 3.5rem;
            color: #5c8a4d;
            padding: 20px;
            background: #1a1a1a;
            margin: 20px 0;
        }
        
        .etiqueta {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #888;
            margin-bottom: 10px;
        }
        
        a {
            display: inline-block;
            padding: 15px 30px;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            background: #3d5c33;
            color: #fff;
            text-decoration: none;
            transition: all 0.15s ease;
            margin-top: 15px;
        }
        
        a:hover {
            background: #5c8a4d;
            transform: translate(-2px, -2px);
            box-shadow: 4px 4px 0 #1a1a1a;
        }
    </style>
</head>
<body>
    <div class="resultado-box">
        <div class="cabecera">
            <h1>Resultado</h1>
        </div>
        
        <div class="contenido">
            <div class="operacion">
                <span class="numero"><?php echo $numero1; ?></span>
                +
                <span class="numero"><?php echo $numero2; ?></span>
            </div>
            
            <p class="etiqueta">La suma es:</p>
            <div class="total"><?php echo $resultado; ?></div>
            
            <a href="formulario_suma.html">← Volver</a>
        </div>
    </div>
</body>
</html>
