-- =============================================
-- FarmAdviseD - Script de Base de Datos
-- Proyecto Ingeniería Web - UAX
-- =============================================

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS farmadvised_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_spanish_ci;

USE farmadvised_db;

-- =============================================
-- TABLA: usuarios
-- Almacena los usuarios registrados
-- =============================================
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,  -- Almacena hash con password_hash()
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB;

-- =============================================
-- TABLA: categorias
-- Categorías de consejos de salud
-- =============================================
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    icono VARCHAR(10) NOT NULL,  -- Emoji o código de icono
    descripcion TEXT
) ENGINE=InnoDB;

-- =============================================
-- TABLA: consejos
-- Consejos de salud y bienestar
-- =============================================
CREATE TABLE IF NOT EXISTS consejos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    contenido TEXT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE,
    INDEX idx_categoria (categoria_id)
) ENGINE=InnoDB;

-- =============================================
-- DATOS INICIALES: Categorías
-- =============================================
INSERT INTO categorias (nombre, icono, descripcion) VALUES
('Nutrición', '🥗', 'Consejos sobre alimentación saludable y dietas equilibradas'),
('Ejercicio', '🏃', 'Rutinas de ejercicio y actividad física'),
('Bienestar', '💆', 'Consejos para el bienestar mental y emocional'),
('Descanso', '😴', 'Mejora la calidad del sueño y el descanso'),
('Natural', '🌿', 'Remedios naturales y fitoterapia'),
('Medicamentos', '💊', 'Información sobre uso responsable de medicamentos');

-- =============================================
-- DATOS INICIALES: Consejos
-- =============================================
INSERT INTO consejos (categoria_id, titulo, contenido) VALUES
-- Nutrición (id=1)
(1, 'Hidratación diaria', 'Beber al menos 2 litros de agua al día mejora la concentración, la digestión y la salud de la piel. Lleva siempre una botella de agua contigo.'),
(1, '5 porciones de frutas y verduras', 'Incluye al menos 5 porciones de frutas y verduras al día para obtener las vitaminas, minerales y fibra que tu cuerpo necesita.'),
(1, 'Reduce el azúcar añadido', 'Limita el consumo de bebidas azucaradas y dulces procesados. Opta por frutas frescas cuando quieras algo dulce.'),
(1, 'Desayuna cada día', 'Un desayuno equilibrado con proteínas, carbohidratos y frutas te da energía para empezar el día con fuerza.'),

-- Ejercicio (id=2)
(2, '30 minutos de caminata', 'Caminar 30 minutos al día reduce el riesgo de enfermedades cardiovasculares y mejora el estado de ánimo.'),
(2, 'Estira antes y después', 'Realiza estiramientos de 5-10 minutos antes y después del ejercicio para prevenir lesiones y mejorar la flexibilidad.'),
(2, 'Ejercicio de fuerza', 'Incluye ejercicios de fuerza 2-3 veces por semana para mantener la masa muscular y fortalecer los huesos.'),
(2, 'Sube escaleras', 'Elige las escaleras en lugar del ascensor. Es un ejercicio simple que mejora tu condición cardiovascular.'),

-- Bienestar (id=3)
(3, 'Respiración profunda', 'Dedica 5 minutos al día a respirar profundamente. Inhala por la nariz 4 segundos, mantén 4 segundos, exhala 4 segundos.'),
(3, 'Desconexión digital', 'Establece momentos del día sin pantallas. Tu mente necesita descansar de la estimulación constante.'),
(3, 'Gratitud diaria', 'Antes de dormir, piensa en 3 cosas por las que estés agradecido. Esta práctica mejora el bienestar emocional.'),
(3, 'Tiempo en la naturaleza', 'Pasa tiempo al aire libre regularmente. La naturaleza reduce el estrés y mejora el estado de ánimo.'),

-- Descanso (id=4)
(4, 'Rutina de sueño', 'Acuéstate y levántate a la misma hora cada día, incluso los fines de semana. Tu cuerpo necesita regularidad.'),
(4, '7-8 horas de sueño', 'Los adultos necesitan entre 7 y 8 horas de sueño para una recuperación óptima del cuerpo y la mente.'),
(4, 'Evita pantallas antes de dormir', 'Deja el móvil y la televisión al menos 1 hora antes de acostarte. La luz azul interfiere con el sueño.'),
(4, 'Habitación oscura y fresca', 'Mantén tu habitación oscura, silenciosa y a temperatura fresca (18-20°C) para dormir mejor.'),

-- Natural (id=5)
(5, 'Infusión de manzanilla', 'La manzanilla tiene propiedades relajantes. Una taza antes de dormir puede ayudarte a conciliar el sueño.'),
(5, 'Jengibre para la digestión', 'El jengibre ayuda a aliviar las náuseas y mejora la digestión. Puedes tomarlo en infusión o añadirlo a las comidas.'),
(5, 'Miel para la garganta', 'La miel tiene propiedades antibacterianas y puede aliviar el dolor de garganta. Añádela a una infusión tibia.'),
(5, 'Aloe vera para la piel', 'El gel de aloe vera hidrata y calma la piel irritada. Es útil para quemaduras solares leves y pequeñas heridas.'),

-- Medicamentos (id=6)
(6, 'Lee siempre el prospecto', 'Antes de tomar cualquier medicamento, lee el prospecto completo para conocer la dosis, efectos secundarios y contraindicaciones.'),
(6, 'No te automediques', 'Consulta siempre a un profesional de la salud antes de tomar medicamentos por tu cuenta, especialmente antibióticos.'),
(6, 'Guarda los medicamentos correctamente', 'Almacena los medicamentos en lugar fresco y seco, lejos de la luz solar y fuera del alcance de los niños.'),
(6, 'Revisa las fechas de caducidad', 'Los medicamentos caducados pueden ser ineficaces o peligrosos. Revisa regularmente tu botiquín.');

-- =============================================
-- Verificar creación
-- =============================================
SELECT 'Base de datos creada correctamente' AS mensaje;
SELECT COUNT(*) AS total_categorias FROM categorias;
SELECT COUNT(*) AS total_consejos FROM consejos;
