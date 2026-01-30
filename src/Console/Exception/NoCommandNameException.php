<?php

namespace Prushak\Framework\Console\Exception;

use Throwable;

class NoCommandNameException extends \Exception
{
    public function __construct(
        string $message = 'A command name must be provided',
        int $code = 0,
        ?Throwable $previous = null )
    {
        parent::__construct($message, $code ,$previous);
    }
}