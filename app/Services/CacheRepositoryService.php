<?php

namespace App\Services;

use App\Contracts\CacheContract;
use Illuminate\Support\Facades\Cache;

/**
 * This class implements the CacheContract interface and provides methods for interacting with the cache.
 */
class CacheRepositoryService implements CacheContract
{
    /**
     * Check if a key exists in the cache.
     *
     * @param string $key The key to check.
     * @return bool True if the key exists, false otherwise.
     */
    public function has(string $key): bool
    {
        return Cache::has($key);
    }

    /**
     * Retrieve an item from the cache by key.
     *
     * @param string $key The key to retrieve.
     * @return mixed The value of the item from the cache.
     */
    public function get(string $key)
    {
        return Cache::get($key);
    }

    /**
     * Store an item in the cache for a given number of minutes.
     *
     * @param string $key The key to store.
     * @param mixed $value The value to store.
     * @param int $minutes The number of minutes to store the item in the cache.
     * @return void
     */
    public function put(string $key, $value, int $minutes): void
    {
        Cache::put($key, $value, $minutes);
    }
}