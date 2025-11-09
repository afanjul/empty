# FacturaCheck - Sistema SaaS Multi-tenant con Verifactu

Sistema de facturación electrónica SaaS para PYMES y profesionales, con cumplimiento total de Verifactu (normativa española de facturación).

## 🚀 Instalación Rápida

### Requisitos Previos

- Docker 20.10 o superior
- Docker Compose 2.0 o superior
- Git

### Pasos de Instalación

**1. Clonar el repositorio**

```bash
git clone <url-del-repositorio>
cd facturacheck
```

**2. Configurar variables de entorno**

```bash
cp .env.example .env
```

Edite el archivo `.env` y configure las siguientes variables **obligatorias**:

```env
# Seguridad - IMPORTANTE: Cambiar estos valores
DB_ROOT_PASSWORD=su_password_seguro_aquí
DB_PASSWORD=su_password_db_aquí
COOKIE_VALIDATION_KEY=genere_clave_aleatoria_32_caracteres
JWT_SECRET=genere_clave_jwt_secreta_aquí
VERIFACTU_SECRET_KEY=su_clave_verifactu_aquí
```

**3. Iniciar los contenedores**

```bash
docker-compose up -d
```

**4. Ejecutar el script de inicialización**

```bash
./docker/init.sh
```

Este script automáticamente:
- Instala las dependencias de Composer
- Ejecuta las migraciones de base de datos
- Crea los directorios necesarios
- Configura permisos

**5. Acceder a la aplicación**

- **Frontend**: http://localhost
- **API REST**: http://localhost/api
- **Admin**: http://localhost/admin
- **phpMyAdmin**: http://localhost:8080

## 🔧 Comandos Útiles

### Gestión de contenedores

```bash
# Iniciar contenedores
docker-compose up -d

# Detener contenedores
docker-compose down

# Ver logs
docker-compose logs -f

# Ver logs de un servicio específico
docker-compose logs -f php
docker-compose logs -f nginx
```

### Comandos de la aplicación

```bash
# Ejecutar migraciones
docker-compose exec php php yii migrate

# Limpiar caché
docker-compose exec php php yii cache/flush-all

# Acceder al contenedor PHP
docker-compose exec php bash

# Acceder a MySQL
docker-compose exec mysql mysql -u facturacheck -p facturacheck
```

## 📚 Uso de la API REST

### Autenticación

Todas las peticiones a la API requieren un token JWT en el header:

```
Authorization: Bearer {token}
```

### Endpoints Principales

#### Crear Factura

```bash
POST /api/invoice
Content-Type: application/json

{
  "document_type_id": 1,
  "issue_date": "2025-11-09",
  "recipient_id": 1,
  "items": [
    {
      "name": "Producto 1",
      "quantity": 2,
      "unit_price": 100.00,
      "tax_rate": 21.0
    }
  ]
}
```

#### Aprobar Factura (genera registro Verifactu)

```bash
POST /api/invoice/{id}/approve
```

#### Obtener PDF de Factura

```bash
GET /api/invoice/{id}/pdf
```

#### Validar Cadena Verifactu

```bash
GET /api/verifactu/validate-chain
```

## 🏗️ Arquitectura

### Stack Tecnológico

- **Backend**: PHP 8.4, Yii2 Framework
- **Base de Datos**: MySQL 8.4
- **Caché**: Redis 7
- **Servidor Web**: Nginx 1.25
- **Contenedores**: Docker & Docker Compose

### Patrón de Arquitectura

```
Request → DTO → Controller → Service Interface → Service → ActiveRecord
```

### Multi-tenancy

El sistema implementa aislamiento completo de datos mediante:
- Campo `tenant_id` en todas las tablas
- `TenantActiveRecord` con filtrado automático
- `TenantManager` para detección y gestión de tenants
- Protección contra acceso cross-tenant

### Verifactu

Implementación completa del sistema Verifactu:
- **Hash encadenado** con HMAC-SHA256
- **Códigos QR** con URL de verificación AEAT
- **Firma digital** con certificados XAdES
- **Numeración secuencial** por serie
- **Auditoría completa** de todas las operaciones

## 📁 Estructura del Proyecto

```
├── api/                    # API REST
│   ├── controllers/        # Controladores API
│   ├── config/            # Configuración API
│   └── web/               # Entry point API
├── backend/               # Panel de administración
├── frontend/              # Portal público
├── console/               # Comandos CLI
│   └── migrations/        # Migraciones de BD
├── common/
│   ├── models/           # Modelos ActiveRecord
│   ├── services/         # Lógica de negocio
│   ├── dto/              # Data Transfer Objects
│   ├── requests/         # Validadores de Request
│   ├── components/       # Componentes (Verifactu, Tenant)
│   ├── behaviors/        # Behaviors (TenantBehavior)
│   └── config/           # Configuración compartida
└── docker/
    ├── nginx/            # Configuración Nginx
    ├── php/              # Dockerfile PHP
    └── mysql/            # Scripts inicialización MySQL
```

## 🔐 Seguridad

- Autenticación JWT para API
- RBAC (Role-Based Access Control) multi-tenant
- Protección cross-tenant automática
- Rate limiting en API
- Validación de inputs con DTOs
- Encriptación de certificados digitales
- Logs de auditoría completos

## 🧪 Testing

```bash
# Ejecutar tests
docker-compose exec php vendor/bin/codecept run

# Tests unitarios
docker-compose exec php vendor/bin/codecept run unit

# Tests funcionales
docker-compose exec php vendor/bin/codecept run functional
```

## 📖 Documentación Adicional

- [IMPLEMENTATION.md](IMPLEMENTATION.md) - Detalles técnicos de implementación
- [VERIFACTU.md](docs/VERIFACTU.md) - Documentación Verifactu
- [DATABASE_SCHEMA.md](docs/DATABASE_SCHEMA.md) - Esquema de base de datos

## 🤝 Contribuir

Para contribuir al proyecto:

1. Fork el repositorio
2. Cree una rama para su feature (`git checkout -b feature/AmazingFeature`)
3. Commit sus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abra un Pull Request

## 📝 Licencia

Este proyecto está bajo licencia MIT.

## 💡 Soporte

Para soporte técnico o consultas, contacte a: support@facturacheck.com

---

# Technical description

FacturaCheck is a multi-tenant SaaS for invoice management.

- Stack: PHP 8.4, Yii2, MySQL 8.4, Redis. Multitenancy: tenant_id field (FK → account) isolation. RBAC: unified Web/API (1 user ↔ 1 api_key). Layers: api, website (product website), frontend (client public portal), console, common, backend, superbackend. Service pattern: Views/Requests → Forms/DTOs → Controllers (Web/API) → ServiceInterface → Service (transactional, tenant-aware) → ActiveRecords. Dual access: REST API and Web (MVC)

- Coding rules (for reference only):. Primary key naming: {model}_id (do not use id as PK). Business models extend TenantActiveRecord; queries extend TenantActiveQuery. Services declared in common/config/services.php; DI via container in common/config/main.php. API routes: api/config/api-route-map.php; rate limits: api/config/api-rate-limits.php. Tenant context via User afterLogin and MultitenancyMiddleware (common/config/main.php). Automatic audit via AuditBehavior on TenantActiveRecord; Audit::log for non-model events. All API controllers extend ApiBaseController or ApiBaseActiveController. Auth via ApiAuthFilter; RBAC via MultiTenantDbManager with tenant-scoped permissions. We use `document` as the business model (shared table) for storing: invoices (`document_type_id`=1), sales receipts (`document_type_id`=2) and credit notes (`document_type_id`=3). Current capability: VERIFACTU implementation completed with hash chaining, QR codes, and digital signatures.
