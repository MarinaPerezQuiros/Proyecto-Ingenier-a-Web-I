# Ejercicio de Feedback - Unidad Didáctica 3
## Ingeniería Web I - FarmAdviseD

### Contenido del ejercicio

Este paquete contiene la resolución de los ejercicios D, E, F y G del feedback:

| Archivo | Ejercicio | Descripción |
|---------|-----------|-------------|
| `pagina_sencilla.html` | D | Página con encabezado, párrafo y lista con CSS |
| `calculadora_js.html` | E | Formulario de suma con JavaScript y DOM |
| `formulario_suma.html` | F | Formulario que envía datos a PHP |
| `sumar.php` | F | Procesa la suma en el servidor |
| `formulario_usuarios.html` | G | Formulario de registro de usuario |
| `guardar_usuario.php` | G | Guarda usuario en MySQL |
| `crear_bd.sql` | G | Script para crear la base de datos |

---

### Instrucciones de instalación

#### Ejercicios D y E (HTML + JavaScript)
Estos archivos funcionan directamente en el navegador, no necesitan servidor.
- Abrir `pagina_sencilla.html` o `calculadora_js.html` directamente con doble clic.

#### Ejercicio F (PHP)
1. Copiar `formulario_suma.html` y `sumar.php` a la carpeta `C:\xampp\htdocs\`
2. Iniciar Apache desde el panel de XAMPP
3. Abrir en el navegador: `http://localhost/formulario_suma.html`

#### Ejercicio G (PHP + MySQL)
1. Copiar `formulario_usuarios.html` y `guardar_usuario.php` a `C:\xampp\htdocs\`
2. Iniciar Apache y MySQL desde el panel de XAMPP
3. Crear la base de datos:
   - Opción A: Abrir PHPMyAdmin (`http://localhost/phpmyadmin`) y ejecutar el contenido de `crear_bd.sql`
   - Opción B: Desde terminal MySQL ejecutar: `source C:\xampp\htdocs\crear_bd.sql`
4. Abrir en el navegador: `http://localhost/formulario_usuarios.html`

---

### Notas sobre la instalación de herramientas (ejercicios A, B, C)

**XAMPP**: Descargar desde https://www.apachefriends.org/
**VS Code**: Descargar desde https://code.visualstudio.com/
**Node.js**: Descargar desde https://nodejs.org/

---

### Estructura del proyecto

```
ejercicio-feedback/
├── pagina_sencilla.html      # Ejercicio D
├── calculadora_js.html       # Ejercicio E
├── formulario_suma.html      # Ejercicio F (HTML)
├── sumar.php                 # Ejercicio F (PHP)
├── formulario_usuarios.html  # Ejercicio G (HTML)
├── guardar_usuario.php       # Ejercicio G (PHP)
├── crear_bd.sql              # Ejercicio G (SQL)
└── README.md                 # Este archivo
```

---

Ingeniería Web I / Web Engineering Full Stack I
Universidad Alfonso X el Sabio
