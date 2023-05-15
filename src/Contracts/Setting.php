<?php

namespace DNT\Setting\Contracts;

use ArrayAccess;
use Illuminate\Support\Collection;

interface Setting extends ArrayAccess
{
    /**
     * Get the value of the key $key. If it does not exist or is null, $default is returned.
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * Set or update the value of $key. You can update multiple keys if $key is an array.
     *
     * @param string|array $key
     * @param mixed|null $value
     * @return static
     */
    public function set(string|array $key, mixed $value = null): static;

    /**
     * Remove one or more keys.
     *
     * @param string|string[] $key
     * @return static
     */
    public function forget(string|array $key): static;

    /**
     * Save previously set or updated values. It will return the array of elements that have been changed.
     *
     * @return array
     */
    public function save(): array;

    /**
     * Check if $key exists.
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Load all key-value pairs in the system.
     *
     * @return array
     */
    public function load(): array;

    /**
     * Refresh values to original state. It returns an array of original key-values.
     *
     * @return array
     */
    public function refresh(): array;

    /**
     * Get all key-values.
     *
     * @return array
     */
    public function all(): array;

    /**
     * Gets all the key-values but instead of returning an array it returns Collection.
     *
     * @return Collection
     */
    public function collection(): Collection;

    /**
     * Returns key-value pairs that have been changed
     *
     * @return array<string,array{old:mixed,new:mixed}>
     */
    public function changed(): array;

    /**
     * Any key-value pair that has been changed will return true.
     *
     * @return bool
     */
    public function isChanged(): bool;
}
