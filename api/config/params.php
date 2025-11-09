<?php

return [
    // API-specific parameters
    'api' => [
        'version' => '1.0',
        'rate_limit' => [
            'requests' => 1000,
            'period' => 3600, // 1 hour
        ],
    ],
];
