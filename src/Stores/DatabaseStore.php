<?php

namespace TekVN\Setting\Stores;

use TekVN\Setting\SettingStore;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Str;

class DatabaseStore extends SettingStore
{
    #[\Override]
    protected function load(): array
    {
        $records = $this->getAllRecords();

        return $records->groupBy('group')->reduce(function ($result, $items) {

            foreach ($items as $item) {
                $value = (array) $item;
                $result[$value['group']][$value['key']] = $this->resolveValue($value['value']);
            }

            return $result;
        }, []);
    }

    private function getAllRecords(): Collection
    {
        return DB::connection($this->getConfig('connection'))
            ->table($this->getConfig('table', 'settings'))
            ->get();
    }

    private function resolveValue(mixed $value): mixed
    {
        if (Str::isJson($value)) {
            return json_decode($value, true);
        }

        return $value;
    }

    #[\Override]
    protected function saveToStore(array $records): void
    {
        $values = [];
        foreach ($records as $groupName => $items) {
            foreach ($items as $keyName => $value) {
                $values[] = [
                    'group' => $groupName,
                    'key' => $keyName,
                    'value' => is_array($value) ? json_encode($value) : $value,
                ];
            }
        }

        $query = DB::connection($this->getConfig('connection'))
            ->table($this->getConfig('table', 'settings'));
        DB::transaction(function () use ($query, $values) {
            $query->clone()->delete();
            $query->clone()->insert($values);
        });
    }
}
