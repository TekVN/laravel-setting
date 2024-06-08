<?php

use Illuminate\Support\Facades\App;

if (! function_exists('setting')) {
    function setting(string|array $key = [], mixed $default = null, string $group = 'default'): mixed
    {
        $instance = App::make('setting');
        if (empty($key)) {
            return $instance;
        }
        if (! is_array($key)) {
            return $instance->get($key, $default, $group);
        }

        return $instance->set($key, $group);
    }
}
