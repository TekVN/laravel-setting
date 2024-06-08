<?php

use DNT\Setting\Contracts\Store;
use DNT\Setting\SettingStore;
use DNT\Setting\Stores\FileStore;

$paths = [
    tmpfile(),
    'tmpdir/setting.json',
    'tmpdir/file_without_ext',
];

dataset('path', $paths);

afterEach(function () use ($paths) {
    foreach ($paths as $path) {
        if (is_resource($path)) {
            $path = stream_get_meta_data($path)['uri'];
        }
        @unlink($path);
    }
});

test('Check implement store', function () {
    expect(FileStore::class)->toExtend(SettingStore::class)
        ->toImplement(Store::class);
});

test('Auto create setting file if not exists', function ($path) {
    new FileStore(compact('path'));

    if (is_resource($path)) {
        $resource = stream_get_meta_data($path);
        $path = $resource['uri'];
    }

    expect(file_exists($path))->toBeTrue()
        ->and(is_writable($path))->toBeTrue()
        ->and(is_readable($path))->toBeTrue();
})->with('path');

test('Read all setting', function ($path) {
    if (is_resource($path)) {
        $resource = stream_get_meta_data($path);
        $path = $resource['uri'];
    }
    $data = [
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
    @mkdir(Str::beforeLast($path, '/'), recursive: true);
    file_put_contents($path, json_encode($data));

    $store = new FileStore(compact('path'));

    expect($store->all())->toMatchArray($data)
        ->and($store->allFromGroup('not_exists'))->toBeArray()->toBeEmpty()
        ->and($store->allFromGroup('default'))->toMatchArray($data['default']);
})->with('path');
