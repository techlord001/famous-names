<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class FamousNamesCacheService
{
    public function cacheNames(): void
    {
        $json = Storage::get('famous-names.json');
        $data = json_decode($json, true);
        
        $names = isset($data['famousNames']) ? $data['famousNames'] : [];
        
        Cache::put('famous-names', $names, 60);
    }
}