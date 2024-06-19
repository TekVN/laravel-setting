<?php

use Illuminate\Support\Facades\App;
use TekVN\Setting\SettingStore;
use TekVN\Setting\StoreManager;

if (! function_exists('setting')) {
    /**
     * @param string|array $key
     * @param mixed|null $default
     * @param string $group
     * @return StoreManager|SettingStore|string|array|null|numeric
     */
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
