<?php

namespace DNT\Setting;

use Illuminate\Support\Facades\Facade as BaseFacade;

class Facade extends BaseFacade
{
    /**
     * @inheritdoc
     */
    public static function getFacadeAccessor(): string
    {
        return 'setting';
    }
}
