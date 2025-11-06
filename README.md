# Proyecto Yii2 Advanced

Este proyecto está basado en la plantilla avanzada de Yii 2, que incluye tres niveles: frontend, backend y consola, cada uno como aplicación separada.

## Requisitos

- PHP 7.4 o superior
- Composer
- MySQL 5.7+ / PostgreSQL / SQLite
- Apache / Nginx

### Extensiones PHP requeridas:
- mbstring
- intl
- pdo_mysql (o pdo_pgsql para PostgreSQL)
- gd o imagick
- openssl

## Instalación

### 1. Clonar el repositorio

```bash
git clone <url-del-repositorio>
cd <nombre-del-proyecto>
```

### 2. Instalar dependencias

```bash
composer install
```

### 3. Inicializar el proyecto

Ejecutar el script de inicialización para configurar el entorno (development o production):

```bash
php init
```

Seleccionar el entorno deseado:
- `0` para Development
- `1` para Production

### 4. Configurar la base de datos

Crear una base de datos MySQL/PostgreSQL y configurar las credenciales en:

**Archivo:** `common/config/main-local.php`

```php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=nombre_db',
            'username' => 'usuario',
            'password' => 'contraseña',
            'charset' => 'utf8',
        ],
    ],
];
```

### 5. Ejecutar migraciones

```bash
php yii migrate
```

### 6. Configurar virtual hosts

#### Apache

Crear dos virtual hosts (frontend y backend):

**Frontend:**
```apache
<VirtualHost *:80>
    ServerName frontend.local
    DocumentRoot "/path/to/project/frontend/web"

    <Directory "/path/to/project/frontend/web">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

**Backend:**
```apache
<VirtualHost *:80>
    ServerName backend.local
    DocumentRoot "/path/to/project/backend/web"

    <Directory "/path/to/project/backend/web">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Agregar a `/etc/hosts`:
```
127.0.0.1 frontend.local
127.0.0.1 backend.local
```

#### Nginx

**Frontend:**
```nginx
server {
    listen 80;
    server_name frontend.local;
    root /path/to/project/frontend/web;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_pass 127.0.0.1:9000;
        try_files $uri =404;
    }
}
```

**Backend:**
```nginx
server {
    listen 80;
    server_name backend.local;
    root /path/to/project/backend/web;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_pass 127.0.0.1:9000;
        try_files $uri =404;
    }
}
```

### 7. Configurar permisos

```bash
chmod -R 777 frontend/runtime
chmod -R 777 frontend/web/assets
chmod -R 777 backend/runtime
chmod -R 777 backend/web/assets
chmod -R 777 console/runtime
```

## Estructura del proyecto

```
common
    config/              archivos de configuración compartidos
    mail/                plantillas de email
    models/              clases de modelo compartidas
    tests/               tests para aplicaciones comunes
console
    config/              archivos de configuración de consola
    controllers/         controladores de consola
    migrations/          migraciones de base de datos
    models/              modelos de consola
    runtime/             archivos generados en tiempo de ejecución
backend
    assets/              definiciones de asset bundles
    config/              archivos de configuración
    controllers/         controladores web
    models/              modelos específicos del backend
    runtime/             archivos generados en tiempo de ejecución
    tests/               tests para la aplicación backend
    views/               vistas
    web/                 punto de entrada, contiene assets web
frontend
    assets/              definiciones de asset bundles
    config/              archivos de configuración
    controllers/         controladores web
    models/              modelos específicos del frontend
    runtime/             archivos generados en tiempo de ejecución
    tests/               tests para la aplicación frontend
    views/               vistas
    web/                 punto de entrada, contiene assets web
vendor/                  paquetes de terceros
environments/            configuraciones de entorno
```

## Uso

### Acceder a las aplicaciones

- **Frontend:** http://frontend.local
- **Backend:** http://backend.local

### Comandos de consola

Ejecutar comandos desde la raíz del proyecto:

```bash
php yii <ruta/al/comando>
```

Ejemplos:

```bash
# Ver todos los comandos disponibles
php yii help

# Limpiar caché
php yii cache/flush-all

# Crear migración
php yii migrate/create nombre_migracion

# Ejecutar migraciones
php yii migrate

# Revertir migración
php yii migrate/down
```

### Crear nuevos módulos

```bash
# Generar CRUD
php yii gii/crud --modelClass="app\models\NombreModelo" --controllerClass="backend\controllers\NombreController"

# Generar modelo
php yii gii/model --tableName="nombre_tabla" --modelClass="NombreModelo"
```

## Testing

### Configurar Codeception

```bash
composer require --dev codeception/codeception
composer require --dev codeception/verify
composer require --dev codeception/specify
```

### Ejecutar tests

```bash
# Tests del frontend
cd frontend
../vendor/bin/codecept run

# Tests del backend
cd backend
../vendor/bin/codecept run

# Tests comunes
cd common
../vendor/bin/codecept run
```

## Configuración adicional

### Configurar mailer

Editar `common/config/main-local.php`:

```php
'components' => [
    'mailer' => [
        'class' => 'yii\swiftmailer\Mailer',
        'viewPath' => '@common/mail',
        'useFileTransport' => false, // establecer en true para modo de prueba
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'smtp.gmail.com',
            'username' => 'tu-email@gmail.com',
            'password' => 'tu-contraseña',
            'port' => '587',
            'encryption' => 'tls',
        ],
    ],
],
```

### Configurar URLs amigables

Ya está configurado en `.htaccess` y en la configuración. Asegurarse de tener `mod_rewrite` habilitado en Apache.

## Despliegue a producción

### 1. Preparar el entorno

```bash
php init --env=Production
```

### 2. Optimizar Composer

```bash
composer install --optimize-autoloader --no-dev
```

### 3. Deshabilitar debug y modo desarrollo

En `frontend/web/index.php` y `backend/web/index.php`:

```php
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');
```

### 4. Ejecutar migraciones

```bash
php yii migrate --interactive=0
```

### 5. Configurar permisos de forma segura

```bash
chmod -R 755 frontend/runtime
chmod -R 755 frontend/web/assets
chmod -R 755 backend/runtime
chmod -R 755 backend/web/assets
```

## Problemas comunes

### Error: "The directory is not writable"

Solución: Verificar permisos de las carpetas `runtime` y `web/assets`.

### Error 404 en todas las rutas

Solución: Verificar que `mod_rewrite` esté habilitado y que el archivo `.htaccess` exista en las carpetas `web`.

### Error de conexión a la base de datos

Solución: Verificar las credenciales en `common/config/main-local.php` y que la base de datos esté creada.

## Recursos

- [Documentación oficial de Yii 2](https://www.yiiframework.com/doc/guide/2.0/es)
- [API Yii 2](https://www.yiiframework.com/doc/api/2.0)
- [Foro de la comunidad](https://forum.yiiframework.com/)
- [GitHub - Yii2 Advanced Template](https://github.com/yiisoft/yii2-app-advanced)

## Contribuir

1. Hacer fork del proyecto
2. Crear una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit de tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abrir un Pull Request

## Licencia

Este proyecto está bajo la Licencia BSD. Ver el archivo `LICENSE.md` para más detalles.

## Contacto

- **Desarrollador:** Tu Nombre
- **Email:** tu-email@ejemplo.com
- **Repositorio:** <url-del-repositorio>

---

Desarrollado con ❤️ usando [Yii Framework 2](https://www.yiiframework.com/)
