<?php

namespace DNT\Setting;

use DNT\Setting\Contracts\Setting as SettingContract;
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

        $this->app->bind(SettingContract::class, function (Application $app) {
            return $app->make('setting')->driver();
        });
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
            ], 'config');
        }

        $this->overrideConfig();
    }

    /**
     * Override configurations with Settings.
     *
     * This method overrides the configurations with the settings
     * obtained from the Setting library. It loops through the overridden
     * settings and updates the corresponding configurations.
     *
     * @return void
     */
    private function overrideConfig(): void
    {
        $overrides = config('setting.overrides');

        foreach ($overrides as $key) {
            if (Facade::has($key)) {
                config([$key => Facade::get($key)]);
            }
        }
    }
}
