#!/bin/bash
# Grant permissions to application user from any host
# This is necessary for Docker container-to-container communication

set -e

# Use environment variables from docker-compose
DB_USER="${MYSQL_USER:-facturacheck}"
DB_PASSWORD="${MYSQL_PASSWORD:-facturacheck}"
DB_NAME="${MYSQL_DATABASE:-facturacheck}"

echo "Granting permissions to $DB_USER from any host..."

# Execute MySQL commands to grant permissions
mysql -u root -p"${MYSQL_ROOT_PASSWORD}" <<-EOSQL
    -- Create user if not exists and set password (MySQL 8.4 compatible)
    CREATE USER IF NOT EXISTS '${DB_USER}'@'%' IDENTIFIED WITH mysql_native_password BY '${DB_PASSWORD}';

    -- Grant all privileges on the application database from any host
    GRANT ALL PRIVILEGES ON ${DB_NAME}.* TO '${DB_USER}'@'%';

    -- Flush privileges to ensure they take effect
    FLUSH PRIVILEGES;

    -- Confirmation message
    SELECT 'Permissions granted to ${DB_USER} user from any host' AS message;
EOSQL

echo "Permissions granted successfully!"
