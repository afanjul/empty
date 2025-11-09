<?php

use yii\caching\RedisCache;
use yii\redis\Connection;
use yii\queue\redis\Queue;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => require __DIR__ . '/db.php',

        // Redis para caché
        'redis' => [
            'class' => Connection::class,
            'hostname' => getenv('REDIS_HOST') ?: 'localhost',
            'port' => getenv('REDIS_PORT') ?: 6379,
            'database' => getenv('REDIS_DB') ?: 0,
            'password' => getenv('REDIS_PASSWORD') ?: null,
        ],

        // Caché con Redis
        'cache' => [
            'class' => RedisCache::class,
            'redis' => [
                'hostname' => getenv('REDIS_HOST') ?: 'localhost',
                'port' => getenv('REDIS_PORT') ?: 6379,
                'database' => getenv('REDIS_CACHE_DB') ?: 1,
                'password' => getenv('REDIS_PASSWORD') ?: null,
            ],
            'keyPrefix' => 'facturacheck:cache:',
        ],

        // Cola de trabajos con Redis
        'queue' => [
            'class' => Queue::class,
            'redis' => 'redis',
            'channel' => 'facturacheck_queue',
        ],

        // Gestor de tenants (multitenencia)
        'tenantManager' => [
            'class' => 'common\components\TenantManager',
        ],

        // Componente Verifactu
        'verifactu' => [
            'class' => 'common\components\VerifactuComponent',
        ],

        // Auth Manager multi-tenant
        'authManager' => [
            'class' => 'common\components\MultiTenantDbManager',
            'cache' => 'cache',
        ],

        // Mailer
        'mailer' => [
            'class' => 'yii\symfonymailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => true,
        ],
    ],

    // Configuración del contenedor de DI para servicios
    'container' => require __DIR__ . '/services.php',

    // Eventos y bootstrapping
    'bootstrap' => ['log', 'queue'],
];
