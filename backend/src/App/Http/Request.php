<?php

namespace App\Http;

class Request
{
    private array $query;
    private array $body;

    public function __construct()
    {
        $this->query = $_GET ?? [];
        $this->body = json_decode(file_get_contents('php://input'), true) ?? [];
    }

    public function input(string $key, $default = null)
    {
        return $this->body[$key] ?? $this->query[$key] ?? $default;
    }
}