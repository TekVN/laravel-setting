<?php

return [
    'default' => env('SETTING_STORE', 'database'),

    'stores' => [
        'database' => [
            'connection' => null,
            'table' => 'settings',
        ],

        'file' => [
            'path' => 'storage/app/setting.json',
            'options' => [
                'json_decode' => JSON_ERROR_NONE,
            ],
        ],
    ],
];
