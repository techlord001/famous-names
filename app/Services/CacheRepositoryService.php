<?php

namespace App\Services;

use App\Contracts\CacheContract;
use Illuminate\Support\Facades\Cache;

class CacheRepositoryService implements CacheContract
{
    public function has(string $key): bool
    {
        return Cache::has($key);
    }

    public function get(string $key)
    {
        return Cache::get($key);
    }

    public function put(string $key, $value, int $minutes): void
    {
        Cache::put($key, $value, $minutes);
    }
}