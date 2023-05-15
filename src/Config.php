<?php

namespace DNT\Setting;

use ArrayAccess;
use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Macroable;

class Config implements ArrayAccess
{
    use Macroable;

    /**
     * It simply saves the configuration values.
     *
     * @var array $config
     */
    private array $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Create a new Config instance if the value isn't one already.
     *
     * @param array $config
     * @return static
     */
    public static function make(array $config = []): static
    {
        return new static($config);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->config[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    /**
     * Get the value of the key $key. If it does not exist or is null, $default is returned.
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->config, $key, $default);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->config[$offset] = $value;
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->config[$offset]);
    }
}
