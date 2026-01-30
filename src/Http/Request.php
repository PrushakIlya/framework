<?php

namespace Prushak\Framework\Http;

readonly class Request {
    public function __construct(
        public array $get,
        public array $post,
        public array $cookie,
        public array $files,
        public array $server,
    )
    {
    }

    public static function createFromGlobals(): static
    {
        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
    }

    public function getPathInfo(): string
    {
        return parse_url($this->server['REQUEST_URI'], PHP_URL_PATH);
    }

    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function getQueryAll() {
        return $this->get;
    }
    
    public function getQuery($id): string 
    {
        return empty($this->get[$id]) ? 1 : $this->get[$id];
    }
}