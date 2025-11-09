#!/bin/bash

# Script de inicialización de Facturacheck
# Este script configura el entorno de desarrollo

set -e

echo "🚀 Iniciando configuración de Facturacheck..."

# Colores para output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Verificar que existe .env
if [ ! -f ".env" ]; then
    echo -e "${YELLOW}⚠️  Archivo .env no encontrado. Copiando desde .env.example...${NC}"
    cp .env.example .env
    echo -e "${GREEN}✓ Archivo .env creado${NC}"
    echo -e "${YELLOW}⚠️  IMPORTANTE: Edite el archivo .env y configure las variables de entorno${NC}"
fi

# Esperar a que MySQL esté listo
echo "⏳ Esperando a que MySQL esté listo..."
sleep 10

# Instalar dependencias de Composer
echo "📦 Instalando dependencias de Composer..."
docker-compose exec php composer install --no-interaction --prefer-dist

# Ejecutar migraciones
echo "🗄️  Ejecutando migraciones de base de datos..."
docker-compose exec php php yii migrate --interactive=0

# Crear directorios necesarios
echo "📁 Creando directorios necesarios..."
docker-compose exec php mkdir -p runtime/logs runtime/cache runtime/sessions
docker-compose exec php mkdir -p common/certificates
docker-compose exec php mkdir -p web/assets

# Configurar permisos
echo "🔐 Configurando permisos..."
docker-compose exec php chmod -R 777 runtime
docker-compose exec php chmod -R 777 web/assets

echo -e "${GREEN}✅ Configuración completada exitosamente!${NC}"
echo ""
echo "🌐 Acceda a la aplicación en:"
echo "   - Frontend: http://localhost"
echo "   - API REST: http://localhost/api"
echo "   - Admin: http://localhost/admin"
echo "   - phpMyAdmin: http://localhost:8080"
echo ""
echo -e "${YELLOW}📝 Próximos pasos:${NC}"
echo "   1. Edite el archivo .env con sus configuraciones"
echo "   2. Configure los certificados digitales en common/certificates/"
echo "   3. Cree un usuario administrador ejecutando:"
echo "      docker-compose exec php php yii user/create admin@example.com password"
