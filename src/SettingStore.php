<?php

namespace TekVN\Setting;

use TekVN\Setting\Contracts\Store;
use TekVN\Setting\Events\SettingSavedEvent;
use TekVN\Setting\Events\SettingSavingEvent;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Traits\Macroable;

abstract class SettingStore implements Store
{
    use Macroable;

    protected array $resources = [];

    protected bool $loaded = false;

    public function __construct(protected array $config)
    {
        $this->forceReload();
    }

    abstract protected function load(): array;

    /**
     * {@inheritDoc}
     */
    #[\Override]
    public function get(string|array $key, mixed $default = null, string $group = 'default'): mixed
    {
        $this->loadIfMissing();

        if (is_array($key)) {
            return Arr::only($this->allFromGroup($group), $key);
        }

        return Arr::get($this->resources, sprintf('%s.%s', $group, $key), $default);
    }

    /**
     * {@inheritDoc}
     */
    #[\Override]
    public function set(string|array $key, mixed $value = null, string $group = 'default'): void
    {
        $this->loadIfMissing();

        $keys = is_array($key) ? $key : [$key => $value];
        foreach ($keys as $k => $v) {
            Arr::set($this->resources, sprintf('%s.%s', $group, $k), $v);
        }

        $this->save();
    }

    /**
     * {@inheritDoc}
     */
    #[\Override]
    public function allFromGroup(string $group): array
    {
        $this->loadIfMissing();

        return Arr::get($this->resources, $group, []);
    }

    /**
     * {@inheritDoc}
     */
    #[\Override]
    public function all(): array
    {
        $this->loadIfMissing();

        return $this->resources;
    }

    /**
     * {@inheritDoc}
     */
    #[\Override]
    public function reload(): void
    {
        $this->forceReload();
    }

    private function loadIfMissing(): void
    {
        if ($this->loaded) {
            return;
        }

        $this->reload();

        $this->loaded = true;
    }

    protected function forceReload(): void
    {
        $this->resources = $this->load();
    }

    protected function getConfig(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->config, $key, $default);
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $key, string $group = 'default'): bool
    {
        $this->loadIfMissing();

        return Arr::has($this->resources, sprintf('%s.%s', $group, $key));
    }

    private function save(): void
    {
        $records = $this->all();
        $this->fire(SettingSavingEvent::class, $records);

        $this->saveToStore($records);

        $this->fire(SettingSavedEvent::class, $records);
    }

    abstract protected function saveToStore(array $records): void;

    private function fire(string $event, array $records): void
    {
        Event::dispatch($event, [$records, $this]);
    }
}
