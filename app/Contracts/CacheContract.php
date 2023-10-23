<?php

namespace App\Contracts;

interface CacheContract
{
    public function has(string $key): bool;
    public function get(string $key);
    public function put(string $key, $value, int $minutes): void;
}