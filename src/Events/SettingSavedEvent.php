<?php

namespace TekVN\Setting\Events;

use TekVN\Setting\Contracts\Store;

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
