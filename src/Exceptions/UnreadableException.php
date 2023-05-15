<?php

namespace DNT\Setting\Exceptions;

use DNT\Setting\Contracts\Setting;
use InvalidArgumentException;
use Throwable;

class UnreadableException extends InvalidArgumentException
{

    public Setting $driver;

    public function __construct(Setting $instance, string $message, int $code = 0, Throwable|null $previous = null)
    {
        $this->driver = $instance;
        parent::__construct($message, $code, $previous);
    }
}
