# FarmAdviseD - Documentación del Proyecto

## 1. Descripción del Proyecto

**FarmAdviseD** es una aplicación web de consejos de salud y bienestar desarrollada como proyecto final de la asignatura Ingeniería Web I.

La aplicación permite a los usuarios:
- Explorar consejos de salud organizados por categorías
- Registrarse e iniciar sesión de forma segura
- Filtrar consejos por categoría de forma dinámica (AJAX)
- Navegar en una interfaz responsiva adaptada a móviles y escritorio

---

## 2. Tecnologías Utilizadas

| Tecnología | Uso |
|------------|-----|
| **HTML5** | Estructura semántica (header, nav, main, footer, article) |
| **CSS3** | Estilos, Flexbox, Grid, Media Queries (diseño responsivo) |
| **JavaScript** | Validaciones, manipulación del DOM, eventos, Fetch API (AJAX) |
| **PHP** | Backend, procesamiento de formularios, conexión a BD |
| **MySQL** | Base de datos relacional |
| **Git/GitHub** | Control de versiones |

---

## 3. Funcionalidades Implementadas

### 3.1 Frontend (HTML/CSS)
- ✅ Estructura HTML semántica
- ✅ Diseño responsivo con media queries
- ✅ Layout con Flexbox y CSS Grid
- ✅ Variables CSS para consistencia de estilos

### 3.2 JavaScript
- ✅ Validación de formularios en el cliente
- ✅ Manipulación del DOM
- ✅ Manejo de eventos (click, submit, blur, change)
- ✅ Comunicación asíncrona con Fetch API (AJAX)
- ✅ Carga dinámica de categorías y consejos

### 3.3 PHP y Seguridad
- ✅ Conexión segura a MySQL
- ✅ Prepared statements (prevención SQL injection)
- ✅ password_hash() para almacenar contraseñas
- ✅ password_verify() para verificar login
- ✅ Sanitización de entradas (htmlspecialchars)
- ✅ Validación del lado del servidor

### 3.4 Base de Datos
- ✅ Tablas: usuarios, categorias, consejos
- ✅ Relaciones con claves foráneas
- ✅ Índices para optimización

### 3.5 AJAX (Fetch API)
- ✅ Carga de categorías sin recargar página
- ✅ Carga de consejos con filtro dinámico
- ✅ Envío de formularios asíncrono
- ✅ Manejo de respuestas JSON

---

## 4. Estructura del Proyecto

```
farmadvised_mini/
├── index.html              # Página principal
├── registro.html           # Formulario de registro
├── login.html              # Formulario de login
├── consejos.html           # Listado de consejos
├── style.css               # Estilos CSS
├── script.js               # JavaScript (validaciones, AJAX)
├── database.sql            # Script SQL de la BD
├── documentacion_proyecto.md
├── README.md
└── api/
    ├── config.php          # Configuración BD
    ├── registro.php        # API registro
    ├── login.php           # API login
    ├── categorias.php      # API categorías (AJAX)
    └── consejos.php        # API consejos (AJAX)
```

---

## 5. Instrucciones de Ejecución

### 5.1 Requisitos
- XAMPP (Apache + MySQL)
- Navegador web moderno

### 5.2 Instalación

1. **Copiar archivos**
   ```
   Copia la carpeta del proyecto a C:\xampp\htdocs\farmadvised_mini\
   ```

2. **Iniciar servicios**
   - Abre el Panel de Control de XAMPP
   - Inicia Apache y MySQL

3. **Crear base de datos**
   - Abre http://localhost/phpmyadmin
   - Ve a la pestaña SQL
   - Copia y ejecuta el contenido de `database.sql`

4. **Configurar conexión (si es necesario)**
   - Abre `api/config.php`
   - Si tu MySQL usa puerto 3306 (por defecto), cambia:
     ```php
     define('DB_HOST', 'localhost');
     ```
   - Si usa puerto 3307:
     ```php
     define('DB_HOST', 'localhost:3307');
     ```

5. **Acceder a la aplicación**
   ```
   http://localhost/farmadvised_mini/index.html
   ```

---

## 6. API Endpoints

| Endpoint | Método | Descripción |
|----------|--------|-------------|
| `/api/registro.php` | POST | Registra nuevo usuario |
| `/api/login.php` | POST | Inicia sesión |
| `/api/categorias.php` | GET | Obtiene todas las categorías |
| `/api/consejos.php` | GET | Obtiene consejos (opcional: ?categoria=id) |

---

## 7. Seguridad Implementada

1. **SQL Injection**: Prevenido con prepared statements
2. **XSS**: Sanitización con htmlspecialchars()
3. **Contraseñas**: Hash con password_hash() (bcrypt)
4. **Validación**: Doble validación (cliente + servidor)

---

## 8. Diseño Responsivo

La aplicación se adapta a diferentes tamaños de pantalla:
- **Desktop** (> 768px): Layout completo con grid
- **Tablet** (768px): Menú hamburguesa, grid 2 columnas
- **Móvil** (< 480px): Layout vertical, 1 columna

---

## 9. Autor

**Nombre:** [Tu nombre]
**Asignatura:** Ingeniería Web I
**Universidad:** Universidad Alfonso X el Sabio
**Fecha:** 2025

---

## 10. Repositorio GitHub

[Incluir enlace al repositorio]
