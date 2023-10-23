<?php

namespace App\Services;

use App\Services\FamousNamesCacheService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class FamousNamesService
{
    protected $cacheService;

    public function __construct(FamousNamesCacheService $cacheService)
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
}