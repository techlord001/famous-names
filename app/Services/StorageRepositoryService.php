<?php

namespace App\Services;

use App\Contracts\StorageContract;
use Illuminate\Support\Facades\Storage;

/**
 * A service class that implements the StorageContract interface and provides methods for interacting with the storage.
 */
class StorageRepositoryService implements StorageContract
{
    /**
     * Get the contents of a file.
     *
     * @param  string  $path
     * @return string|false
     */
    public function get(string $path)
    {
        return Storage::get($path);
    }
}