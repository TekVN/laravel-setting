<?php

namespace DNT\Setting\Events;

use DNT\Setting\Contracts\Store;

class SettingSavingEvent
{
    public function __construct(
        public array $records,
        protected Store $store,
    ) {
    }
}
