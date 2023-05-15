<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Driver
    |--------------------------------------------------------------------------
    |
    | This option specifies the default driver to be used for storing the settings.
    | By default, it is set to 'json'.
    |
    */
    'default' => 'json',

    /*
    |--------------------------------------------------------------------------
    | Drivers Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can define the configuration for each driver supported by the package.
    | Currently, only the 'json' driver is supported.
    |
    */
    'drivers' => [
        'json' => [
            /*
            |--------------------------------------------------------------------------
            | JSON File Path
            |--------------------------------------------------------------------------
            |
            | This option specifies the path to the JSON file where the settings
            | will be stored when using the 'json' driver. You can modify this
            | path as per your application's requirements.
            |
            */
            'path' => storage_path('app/setting.json')
        ]
    ]
];
