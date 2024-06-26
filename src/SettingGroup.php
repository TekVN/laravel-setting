<?php

namespace TekVN\Setting;

use TekVN\Setting\Contracts\Group;
use TekVN\Setting\Contracts\Store;
use Illuminate\Support\Facades\App;

class SettingGroup implements Group
{
    protected Store $store;

    protected string $group = 'default';

    /**
     * {@inheritDoc}
     */
    #[\Override]
    public function getGroupName(): string
    {
        return $this->group;
    }

    /**
     * {@inheritDoc}
     */
    #[\Override]
    public function getStore(): Store
    {
        if (empty($this->store)) {
            $this->store = $this->resolveStore();
        }

        return $this->store;
    }

    /**
     * {@inheritDoc}
     */
    #[\Override]
    public function all(): array
    {
        return $this->getStore()->allFromGroup($this->getGroupName());
    }

    /**
     * {@inheritDoc}
     */
    #[\Override]
    public function get(string|array $key, mixed $default = null): mixed
    {
        return $this->getStore()->get($key, $default, $this->getGroupName());
    }

    /**
     * {@inheritDoc}
     */
    #[\Override]
    public function set(string|array $key, mixed $value = null): void
    {
        $this->getStore()->set($key, $value, $this->getGroupName());
    }

    /**
     * {@inheritDoc}
     */
    #[\Override]
    public function getStoreDriver(): ?string
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    #[\Override]
    public function reload(): void
    {
        $this->getStore()->reload();
    }

    private function resolveStore(): Store
    {
        return App::make(StoreManager::class)->driver($this->getStoreDriver());
    }
}
