<?php

namespace Prushak\Framework\Exception;

use Throwable;

class HttpException extends \Exception {
    public function __construct(
        string $message = "That route does not exist",
        int $code = 404,
        ?Throwable $previous = null
    ){
        parent::__construct($message, $code, $previous);
    }
}