<?php

namespace App\Services;

use App\Contracts\StorageContract;
use Illuminate\Support\Facades\Storage;

class StorageRepositoryService implements StorageContract
{
    public function get(string $path)
    {
        return Storage::get($path);
    }
}