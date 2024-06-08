<?php

namespace DNT\Setting\Stores;

use DNT\Setting\Exceptions\UnreadableSettingException;
use DNT\Setting\Exceptions\UnwritableSettingException;
use DNT\Setting\SettingStore;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class FileStore extends SettingStore
{
    #[\Override]
    protected function load(): array
    {
        return $this->getAllRecords()->all();
    }

    private function getAllRecords(): Collection
    {
        $path = $this->resolvePath();
        $flags = $this->getConfig('options.json_decode', JSON_ERROR_NONE);

        $content = file_get_contents($path);
        $json = json_decode($content, true, flags: $flags);

        return new Collection($json ?? []);
    }

    /**
     * @throws UnreadableSettingException
     * @throws UnwritableSettingException
     */
    private function resolvePath(): string
    {
        $path = $this->getConfig('path', 'setting.json');
        if (is_resource($path)) {
            $resource = stream_get_meta_data($path);
            $path = $resource['uri'];
        }

        if (! file_exists($path)) {
            $this->createDirectory($path);
            file_put_contents($path, '{}');
        }

        $this->checkPermission($path);

        return $path;
    }

    /**
     * @throws UnwritableSettingException
     * @throws UnreadableSettingException
     */
    private function checkPermission(string $path): void
    {
        if (! is_writable($path)) {
            throw new UnwritableSettingException();
        }
        if (! is_readable($path)) {
            throw new UnreadableSettingException();
        }
    }

    private function createDirectory(string $path): void
    {
        $dir = Str::beforeLast($path, '/');
        if (file_exists($dir)) {
            return;
        }
        @mkdir($dir, 0755, true);
    }
}
