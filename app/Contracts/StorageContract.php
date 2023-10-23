<?php

namespace App\Contracts;

/**
 * Interface for storage classes.
 */
interface StorageContract
{
    /**
     * Get the contents of a file.
     *
     * @param string $path The path to the file.
     * @return mixed The contents of the file.
     */
    public function get(string $path);
}