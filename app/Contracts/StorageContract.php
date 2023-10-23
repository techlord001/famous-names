<?php

namespace App\Contracts;

interface StorageContract
{
    public function get(string $path);
}