<?php

use DNT\Setting\Contracts\Store;
use DNT\Setting\SettingStore;
use DNT\Setting\Stores\DatabaseStore;
use Illuminate\Foundation\Testing\RefreshDatabase;

$defaultDataDatabase = [
    [
        'key' => 'key1',
        'value' => 'value1',
        'group' => 'default',
    ], [
        'key' => 'key2',
        'value' => null,
        'group' => 'default',
    ], [
        'key' => 'key3',
        'value' => [
            'array',
        ],
        'group' => 'default',
    ], [
        'key' => 'key4',
        'value' => ['array_key' => 'array_value'],
        'group' => 'default',
    ],
];

$defaultRecordSetting = [
    'default' => [
        'key1' => 'value1',
        'key2' => null,
        'key3' => [
            'array',
        ],
        'key4' => [
            'array_key' => 'array_value',
        ],
    ],
];

uses(RefreshDatabase::class);

test('Check implement store', function () {
    expect(DatabaseStore::class)->toExtend(SettingStore::class)
        ->toImplement(Store::class);
});

test('Read all setting', function () use ($defaultRecordSetting, $defaultDataDatabase) {
    foreach ($defaultDataDatabase as $key => $item) {
        if (is_array($item['value'])) {
            $defaultDataDatabase[$key]['value'] = json_encode($item['value']);
        }
    }

    DB::connection()->table('settings')->insert($defaultDataDatabase);

    $store = new DatabaseStore([]);

    expect($store->all())->toMatchArray($defaultRecordSetting)
        ->and($store->allFromGroup('not_exists'))->toBeArray()->toBeEmpty()
        ->and($store->allFromGroup('default'))->toMatchArray($defaultRecordSetting['default']);
});

test('Set value for key', function () {
    $store = new DatabaseStore([]);

    $value = $store->set('key1', 'value1');

    expect($value)->toEqual($value)
        ->and($store->allFromGroup('default'))->toMatchArray([
            'key1' => 'value1',
        ]);
});
