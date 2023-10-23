<?php

namespace App\Services;

use App\Contracts\CacheContract;
use App\Contracts\StorageContract;

class FamousNamesService
{
    protected $cacheRepository;
    protected $storageRepository;

    public function __construct(CacheContract $cacheRepository, StorageContract $storageRepository)
    {
        $this->cacheRepository = $cacheRepository;
        $this->storageRepository = $storageRepository;
    }

    public function getNames(): array
    {
        if (!$this->cacheRepository->has('famous-names')) {
            $json = $this->storageRepository->get('famous-names.json');
            $data = json_decode($json, true);
            $names = isset($data['famousNames']) ? $data['famousNames'] : [];

            $this->cacheRepository->put('famous-names', $names, 60);
        }

        return $this->cacheRepository->get('famous-names');
    }

    public function updateName($id, $updatedData)
    {
        $names = $this->getNames();
        foreach ($names as &$name) {
            if ($name['id'] == $id) {
                $name = array_merge($name, $updatedData);
                break;
            }
        }
        
        $this->cacheRepository->put('famous-names', $names, 60);
    }


    public function deleteName(int $id): void
    {
        $names = $this->getNames();
        $names = array_filter($names, function ($name) use ($id) {
            return $name['id'] !== $id;
        });

        $this->cacheRepository->put('famous-names', $names, 60);
    }
}
