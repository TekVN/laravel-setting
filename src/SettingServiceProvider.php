<?php

namespace DNT\Setting;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * @inheritdoc
     */
    public function register(): void
    {
        $this->mergeConfigFrom($this->getConfigPath(), 'setting');

        $this->app->singleton('setting', function (Application $app) {
            return new Setting($app);
        });
    }

    /**
     * Get configuration path.
     *
     * @return string
     */
    protected function getConfigPath(): string
    {
        return __DIR__ . '/config/setting.php';
    }

    /**
     * Boot any application service.
     *
     * @return void
     */
    public function boot(): void
    {
        /**
         * We only want the application to execute if the request comes from the console.
         */
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->getConfigPath() => $this->app->configPath('setting.php')
            ], 'setting');
        }
    }
}
