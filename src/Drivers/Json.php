<?php

namespace DNT\Setting\Drivers;

use DNT\Setting\BaseDriver;
use DNT\Setting\Exceptions\JsonException;
use DNT\Setting\Exceptions\SaveSettingException;
use DNT\Setting\Exceptions\UnreadableException;
use DNT\Setting\Exceptions\UnwritableException;
use Illuminate\Support\Facades\File;
use Throwable;

class Json extends BaseDriver
{
    /**
     * @inheritDoc
     */
    public function save(): array
    {
        $changed = $this->changed();
        // We only save when there has been a change.
        if (!empty($changed)) {
            $items = $this->all();
            $this->writeToFile($items);
            $this->original = $items;
        }

        return $changed;
    }

    /**
     * @throws SaveSettingException|JsonException|Throwable
     */
    protected function writeToFile(array $items): void
    {
        $path = $this->getPath();

        if (File::exists($path)) {
            throw_if(!File::isWritable($path), UnwritableException::class, $this, "Could not write to {$path}.");
        }

        $content = json_encode($items, JSON_PRETTY_PRINT);
        $encodeError = $content === false || json_last_error();
        throw_if($encodeError, JsonException::class, $this, 'Failed to encode JSON for settings.');

        throw_if(!File::put($path, $content), SaveSettingException::class, $this, 'Failed to write settings to file.');
    }

    /**
     * Returns the path where the configuration json file is stored.
     *
     * @return string
     */
    protected function getPath(): string
    {
        return $this->config->get('drivers.json.path', 'setting.json');
    }

    /**
     * @inheritDoc
     * @throws JsonException|Throwable
     */
    public function load(): array
    {
        $path = $this->getPath();

        if (!File::exists($path)) {
            $this->writeToFile([]);
            return $this->items = $this->original = [];
        }

        throw_if(!File::isReadable($path), UnreadableException::class, $this, "Could not read from {$path}.");

        $content = File::get($path);
        $items = json_decode($content, true);

        throw_if(json_last_error(), JsonException::class, $this, 'Failed to decode JSON from settings file');

        $this->items = $this->original = $items;

        return $this->all();
    }
}
