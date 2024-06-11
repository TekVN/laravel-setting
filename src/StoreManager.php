<?php

namespace TekVN\Setting;

use TekVN\Setting\Contracts\Store;
use TekVN\Setting\Stores\DatabaseStore;
use TekVN\Setting\Stores\FileStore;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Manager;
use Override;

class StoreManager extends Manager
{
    /**
     * {@inheritDoc}
     */
    #[Override]
    public function getDefaultDriver(): string
    {
        return $this->config->get('setting.default', 'database');
    }

    protected function createDatabaseDriver(): Store
    {
        $config = $this->getContainer()->make(Repository::class);

        return new DatabaseStore($config->get('setting.stores.database', [
            'connection' => null,
            'table' => 'settings',
        ]));
    }

    protected function createFileDriver(): Store
    {
        $config = $this->getContainer()->make(Repository::class);

        return new FileStore($config->get('setting.stores.file', [
            'path' => 'storage/app/setting.json',
        ]));
    }
}
