-- Inicialización de la base de datos Facturacheck
-- Este script se ejecuta automáticamente al crear el contenedor MySQL

-- Asegurar que la base de datos usa UTF-8
ALTER DATABASE facturacheck CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Configurar zona horaria
SET time_zone = '+01:00';

-- Mensaje de confirmación
SELECT 'Base de datos Facturacheck inicializada correctamente' AS mensaje;
