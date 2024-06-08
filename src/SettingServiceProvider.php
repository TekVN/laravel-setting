<?php

namespace DNT\Setting;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->registerConfiguration();

        $this->app->singleton('setting', function (Application $app) {
            return new StoreManager($app);
        });

        $this->app->singleton('setting.store', function (Application $app) {
            return $app->make('setting')->driver();
        });
    }

    /**
     * Boot the service provider.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->bootInConsole();
        }

        Event::subscribe(SettingSubscriber::class);
    }

    private function bootInConsole(): void
    {
        $this->loadMigrationsFrom(dirname(__DIR__).'/database/migrations');

        $this->publishes([
            dirname(__DIR__).'/config/setting.php' => $this->app->configPath('setting.php'),
        ], 'config');

        $this->publishes([
            dirname(__DIR__).'/database/migrations' => $this->app->databasePath('migrations'),
        ], 'migration');
    }

    private function registerConfiguration(): void
    {
        $this->mergeConfigFrom(dirname(__DIR__).'/config/setting.php', 'setting');
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [
            'setting', 'setting.store',
        ];
    }
}
