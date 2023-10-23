<?php

namespace App\Services;

use App\Contracts\CacheServiceContract;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class FamousNamesService
{
    protected $cacheService;

    public function __construct(CacheServiceContract $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function getNames(): array
    {
        if (!Cache::has('famous-names')) {
            $this->cacheService->cacheNames();
        }
        
        return Cache::get('famous-names');
    }

    public function deleteName(int $id): void
    {
        $names = $this->getNames();
        $names = array_filter($names, function ($name) use ($id) {
            return $name['id'] !== $id;
        });

        Cache::put('famous-names', $names, 60);
    }
}