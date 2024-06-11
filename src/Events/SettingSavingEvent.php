<?php

namespace TekVN\Setting\Events;

use TekVN\Setting\Contracts\Store;

class SettingSavingEvent
{
    public function __construct(
        public array $records,
        protected Store $store,
    ) {
    }
}
