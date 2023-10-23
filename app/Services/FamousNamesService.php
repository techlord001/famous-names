<?php

namespace App\Services;

use App\Contracts\CacheContract;
use App\Contracts\StorageContract;

/**
 * The FamousNamesService class provides methods for retrieving, updating, and deleting famous names.
 */
class FamousNamesService
{
    protected $cacheRepository;
    protected $storageRepository;

    /**
     * Create a new FamousNamesService instance.
     *
     * @param CacheContract $cacheRepository The cache repository implementation.
     * @param StorageContract $storageRepository The storage repository implementation.
     * @return void
     */
    public function __construct(CacheContract $cacheRepository, StorageContract $storageRepository)
    {
        $this->cacheRepository = $cacheRepository;
        $this->storageRepository = $storageRepository;
    }

    /**
     * Get the list of famous names.
     *
     * @return array The list of famous names.
     */
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

    /**
     * Update a famous name.
     *
     * @param int $id The ID of the famous name to update.
     * @param array $updatedData The updated data for the famous name.
     * @return void
     */
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

    /**
     * Delete a famous name.
     *
     * @param int $id The ID of the famous name to delete.
     * @return void
     */
    public function deleteName(int $id): void
    {
        $names = $this->getNames();
        $names = array_filter($names, function ($name) use ($id) {
            return $name['id'] !== $id;
        });

        $this->cacheRepository->put('famous-names', $names, 60);
    }
}
