<?php

use common\interfaces\InvoiceServiceInterface;
use common\interfaces\ContactServiceInterface;
use common\interfaces\VerifactuServiceInterface;
use common\interfaces\TenantServiceInterface;
use common\interfaces\AuditServiceInterface;
use common\services\InvoiceService;
use common\services\ContactService;
use common\services\VerifactuService;
use common\services\TenantService;
use common\services\AuditService;
use yii\di\Container;
use yii\di\Instance;

return [
    'definitions' => [
        // Interfaces de servicios → Implementaciones
        InvoiceServiceInterface::class => InvoiceService::class,
        ContactServiceInterface::class => ContactService::class,
        VerifactuServiceInterface::class => VerifactuService::class,
        TenantServiceInterface::class => TenantService::class,
        AuditServiceInterface::class => AuditService::class,
    ],
    'singletons' => [
        // Servicios como singletons para optimización
        InvoiceServiceInterface::class => InvoiceService::class,
        ContactServiceInterface::class => ContactService::class,
        VerifactuServiceInterface::class => VerifactuService::class,
        TenantServiceInterface::class => TenantService::class,
        AuditServiceInterface::class => AuditService::class,
    ],
];
