<?php

namespace App\Services;

use App\Contracts\NameServiceInterface;
use Illuminate\Support\Facades\Storage;

class FamousNameService implements NameServiceInterface
{
    public function getNames(): array
    {
        $json = Storage::get('famous-names.json');
        $data = json_decode($json, true);
        
        return isset($data['famousNames']) ? $data['famousNames'] : [];
    }
}