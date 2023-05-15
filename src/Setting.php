<?php

namespace DNT\Setting;

use DNT\Setting\Drivers\Json;
use Illuminate\Support\Manager;

class Setting extends Manager
{
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver(): string
    {
        return $this->config('default', 'json');
    }

    /**
     * The function provides a quick way to get the library's config.
     *
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    public function config(string|null $key = null, mixed $default = null): mixed
    {
        $key ??= '';
        if ($key == '') {
            return $this->config->get('setting');
        }

        return $this->config->get(sprintf('setting.%s', $key), $default);
    }

    /**
     * This driver uses json to save the configuration.
     *
     * @return Json
     */
    public function createJsonDriver(): Json
    {
        return new Json(Config::make($this->config()));
    }
}
