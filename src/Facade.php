<?php

namespace DNT\Setting;

use DNT\Setting\Contracts\Setting as SettingsContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade as BaseFacade;

/**
 * This class serves as the facade for accessing the Setting library in a Laravel application.
 * It provides a static interface for interacting with the Setting instance without the need
 * for manual dependency injection.
 *
 * @method static mixed get(string $key, mixed $default = null)
 * @method static static set(string|array $key, mixed $value = null)
 * @method static void forget(string|array $key)
 * @method static array save()
 * @method static bool has(string $key)
 * @method static array load()
 * @method static array refresh()
 * @method static array all()
 * @method static Collection collection()
 * @method static array changed()
 * @method static bool isChanged()
 *
 * @see SettingsContract
 */
class Facade extends BaseFacade
{
    /**
     * @inheritdoc
     */
    public static function getFacadeAccessor(): string
    {
        return SettingsContract::class;
    }
}
