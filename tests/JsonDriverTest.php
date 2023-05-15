<?php

namespace DNT\Setting\Tests;

use DNT\Setting\Exceptions\JsonException;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    $path = stream_get_meta_data(tmpfile())['uri'];
    config(['setting.drivers.json.path' => $path]);
});

afterEach(function () {
    $path = config('setting.drivers.json.path');
    if (File::exists($path)) {
        File::delete($path);
    }
});

it('The archive file should be created if it did not previously exist', function () {
    $items = setting()->all();

    $this->assertEquals([], $items);
    $this->assertTrue(file_exists(config('setting.drivers.json.path')));
});

it('Throw exception if content cannot be read', function () {
    $path = config('setting.drivers.json.path');
    File::put($path, '{');

    expect(fn() => setting()->all())->toThrow(JsonException::class);
});

it('Make sure the data reads exactly what was saved', function () {
    $path = config('setting.drivers.json.path');
    File::put($path, '{"foo":"bar","bar":["foo1","foo2"],"something":{"foo":"bar"}}');

    $this->assertEquals('bar', setting('foo'));
    $this->assertEquals(['foo1', 'foo2'], setting('bar'));
    $this->assertEquals(['foo' => 'bar'], setting('something'));
    $this->assertEquals(['foo' => 'bar', 'bar' => ['foo1', 'foo2'], 'something' => ['foo' => 'bar']], setting()->all());
});

it('Make sure data is recorded exactly as expected', function () {
    $path = config('setting.drivers.json.path');
    File::put($path, '{"foo":"bar"}');

    setting([
        'bar' => ['foo1', 'foo2']
    ]);

    $this->assertTrue(setting()->isChanged());
    $this->assertNotEmpty(setting()->changed());

    setting()->save();

    $this->assertEquals(['foo1', 'foo2'], setting('bar'));
    $this->assertEquals(['foo' => 'bar', 'bar' => ['foo1', 'foo2']], setting()->all());
    $this->assertFalse(setting()->isChanged());
    $this->assertEmpty(setting()->changed());
});

it('Make sure deleted keys are removed', function () {
    $path = config('setting.drivers.json.path');
    File::put($path, '{"foo":"bar"}');

    setting()->forget('foo')->save();

    $this->assertEquals(null, setting('foo'));
    $this->assertEquals([], setting()->all());
    $this->assertFalse(setting()->isChanged());
});
