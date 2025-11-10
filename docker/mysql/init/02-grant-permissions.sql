-- Grant permissions to application user from any host
-- This is necessary for Docker container-to-container communication
-- Note: The MYSQL_USER environment variable automatically creates 'facturacheck'@'localhost'
-- We need to also grant access from '%' (any host) for Docker networking

-- Create user for any host with the password from environment
-- Using mysql_native_password for backward compatibility
CREATE USER IF NOT EXISTS 'facturacheck'@'%' IDENTIFIED WITH mysql_native_password BY 'rufo4321';

-- Grant all privileges on the application database
GRANT ALL PRIVILEGES ON `facturacheck`.* TO 'facturacheck'@'%';

-- Flush privileges to ensure they take effect immediately
FLUSH PRIVILEGES;

-- Confirmation
SELECT 'User permissions granted for remote access' AS Status;
