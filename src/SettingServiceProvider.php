<?php

namespace TekVN\Setting;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use TekVN\Setting\Contracts\Group;
use TekVN\Setting\Contracts\SettingManager;
use TekVN\Setting\Contracts\Store;

class SettingServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->registerConfiguration();

        $this->app->singleton(SettingManager::class, function (Application $app) {
            return new StoreManager($app);
        });

        $this->app->singleton(Store::class, function (Application $app) {
            return $app->make('setting')->driver();
        });

        $this->app->bind('setting', SettingManager::class);
        $this->app->bind('setting.store', Store::class);
        $this->app->bind('setting.group', Group::class);
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
