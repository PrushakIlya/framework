<?php

namespace Prushak\Framework\Exception;

use Throwable;

class HttpRequestMethodException extends HttpException {
    public function __construct(
        string $message = "Method not allowed",
        int $code = 405,
        ?Throwable $previous = null
    ){
        parent::__construct($message, $code, $previous);
    }
}