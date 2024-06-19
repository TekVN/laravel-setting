<?php

namespace TekVN\Setting;

use Illuminate\Support\Facades\Facade as BaseFacade;

/**
 * @mixin SettingStore
 */
class Facade extends BaseFacade
{
    /**
     * {@inheritDoc}
     */
    public static function getFacadeAccessor(): string
    {
        return 'setting';
    }
}
