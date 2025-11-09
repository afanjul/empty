<?php

return [
    // Health check
    'GET health' => 'site/health',

    // Invoices/Documents
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'invoice',
        'pluralize' => false,
        'extraPatterns' => [
            'POST {id}/approve' => 'approve',
            'POST {id}/send-email' => 'send-email',
            'GET {id}/pdf' => 'pdf',
        ],
    ],

    // Contacts
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'contact',
        'pluralize' => false,
        'extraPatterns' => [
            'GET search' => 'search',
        ],
    ],

    // Verifactu
    'GET verifactu/validate-chain' => 'verifactu/validate-chain',
    'POST verifactu/{id}/sign' => 'verifactu/sign',
    'POST verifactu/{id}/generate-qr' => 'verifactu/generate-qr',
];
