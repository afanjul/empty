<?php

return [
    'adminEmail' => getenv('ADMIN_EMAIL') ?: 'admin@facturacheck.com',
    'supportEmail' => getenv('SUPPORT_EMAIL') ?: 'support@facturacheck.com',
    'senderEmail' => getenv('SENDER_EMAIL') ?: 'noreply@facturacheck.com',
    'senderName' => getenv('SENDER_NAME') ?: 'FacturaCheck',

    // Configuración de Verifactu
    'verifactu' => [
        'version' => '1.0',
        'hashAlgorithm' => 'sha256',
        'signatureAlgorithm' => 'sha256WithRSAEncryption',
        'qrCodeSize' => 300,
        'aeat' => [
            'endpoint' => getenv('AEAT_ENDPOINT') ?: 'https://prewww1.aeat.es/wlpl/TIKE-CONT/ValidarQR',
            'timeout' => 30,
            'retryAttempts' => 3,
        ],
    ],

    // Configuración de multitenencia
    'tenant' => [
        'detectionMethod' => 'subdomain', // 'subdomain', 'header', 'parameter'
        'headerName' => 'X-Tenant-Id',
        'parameterName' => 'tenant_id',
        'cacheTimeout' => 3600,
    ],

    // Configuración de JWT
    'jwt' => [
        'key' => getenv('JWT_SECRET') ?: 'your-secret-key-change-in-production',
        'algorithm' => 'HS256',
        'ttl' => 3600, // 1 hora
        'refreshTtl' => 604800, // 7 días
    ],

    // Límites por plan
    'planLimits' => [
        'trial' => [
            'maxInvoices' => 10,
            'maxContacts' => 50,
            'maxUsers' => 2,
            'features' => ['basic_invoicing', 'verifactu'],
        ],
        'basic' => [
            'maxInvoices' => 100,
            'maxContacts' => 500,
            'maxUsers' => 5,
            'features' => ['basic_invoicing', 'verifactu', 'api_access'],
        ],
        'professional' => [
            'maxInvoices' => 1000,
            'maxContacts' => 5000,
            'maxUsers' => 20,
            'features' => ['basic_invoicing', 'verifactu', 'api_access', 'advanced_reports', 'custom_templates'],
        ],
        'enterprise' => [
            'maxInvoices' => PHP_INT_MAX,
            'maxContacts' => PHP_INT_MAX,
            'maxUsers' => PHP_INT_MAX,
            'features' => ['basic_invoicing', 'verifactu', 'api_access', 'advanced_reports', 'custom_templates', 'priority_support', 'dedicated_server'],
        ],
    ],
];
