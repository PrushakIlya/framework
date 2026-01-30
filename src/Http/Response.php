<?php

namespace Prushak\Framework\Http;

class Response {
    public const HTTP_SERVER_ERROR = 500;
    public function __construct(
        private string $content = '',
        private int    $status = 200,
        private array  $headers = [],
    )
    {
        http_response_code($this->status);
    }
}