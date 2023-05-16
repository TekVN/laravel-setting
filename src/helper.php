<?php

use DNT\Setting\Contracts\Setting;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

if (!function_exists('setting')) {
    /**
     * @param $key
     * @param $default
     * @return mixed|Setting
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    function setting($key = null, $default = null): mixed
    {
        $setting = app(Setting::class);
        // https://www.php.net/manual/en/function.is-null.php#84161
        if ($key === null) {
            return $setting;
        }
        if (is_array($key)) {
            return $setting->set($key);
        }
        return $setting->get($key, $default);
    }
}
