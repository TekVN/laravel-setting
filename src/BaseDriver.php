<?php

namespace DNT\Setting;

use DNT\Setting\Contracts\Setting as Contract;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

abstract class BaseDriver implements Contract
{
    protected Config $config;

    /**
     * Save the key-value pairs in use. These key-value pairs may have not been saved.
     *
     * @var array
     */
    protected array $items = [];

    /**
     * Store saved key-value pairs.
     *
     * @var array
     */
    protected array $original = [];

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->load();
    }

    /**
     * @inheritDoc
     */
    public function refresh(): array
    {
        $this->items = $this->original;
        return $this->all();
    }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * @inheritDoc
     */
    public function collection(): Collection
    {
        return Collection::make($this->all());
    }

    /**
     * @inheritDoc
     */
    public function offsetExists(mixed $offset): bool
    {
        return $this->has($offset);
    }

    /**
     * @inheritdoc
     */
    public function has(string $key): bool
    {
        return Arr::has($this->all(), $key);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    /**
     * @inheritDoc
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->all(), $key, $default);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->set($offset, $value);
    }

    /**
     * @inheritDoc
     */
    public function set(array|string $key, mixed $value = null): static
    {
        if (is_array($key)) {
            foreach ($key as $k => $value) {
                Arr::set($this->items, $k, $value);
            }
        } else {
            Arr::set($this->items, $key, $value);
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->forget($offset);
    }

    /**
     * @inheritDoc
     */
    public function forget(array|string $key): static
    {
        if (is_array($key)) {
            foreach ($key as $k) {
                unset($this->items[$k]);
            }
        } else {
            unset($this->items[$key]);
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function isChanged(): bool
    {
        return !empty($this->changed());
    }

    /**
     * @inheritdoc
     */
    public function changed(): array
    {
        $changed = [];

        // Find newly added or modified $key.
        foreach ($this->all() as $key => $value) {
            // If $key does not exist, it means that this $key is added, old will not be valid.
            // We do this because old can be null.
            if (!isset($this->original[$key])) {
                $changed[$key] = [
                    'new' => $value
                ];
                continue;
            }

            if ($this->original[$key] === $value) {
                continue;
            }

            // Indicate the change of $key.
            $changed[$key] = [
                'old' => $this->original[$key],
                'new' => $value
            ];
        }

        // Find deleted $key.
        foreach ($this->original as $key => $value) {
            // If $key does not exist, it means that $key has been deleted, new will not exist.
            // We do this because new can be null.
            if (!$this->has($key)) {
                $changed[$key] = [
                    'old' => $this->original[$key]
                ];
            }
        }

        return $changed;
    }
}
