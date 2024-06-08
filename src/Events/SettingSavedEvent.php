<?php

namespace DNT\Setting\Events;

use DNT\Setting\Contracts\Store;

class SettingSavedEvent
{
    public function __construct(
        public array $records,
        protected Store $store,
    ) {
    }

    public function getStore(): Store
    {
        return $this->store;
    }
}
