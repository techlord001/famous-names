<?php

namespace App\Contracts;

/**
 * Interface for caching implementation.
 */
interface CacheContract
{
    /**
     * Determine if an item exists in the cache.
     *
     * @param  string  $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Retrieve an item from the cache by key.
     *
     * @param  string  $key
     * @return mixed
     */
    public function get(string $key);

    /**
     * Store an item in the cache for a given number of minutes.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @param  int  $minutes
     * @return void
     */
    public function put(string $key, $value, int $minutes): void;
}