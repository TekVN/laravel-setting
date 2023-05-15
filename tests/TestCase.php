<?php

namespace DNT\Setting\Tests;

use DNT\Setting\SettingServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * @inheritDoc
     */
    protected function getPackageProviders($app): array
    {
        return [
            SettingServiceProvider::class,
        ];
    }

}
