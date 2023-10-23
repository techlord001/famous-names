<?php

namespace App\Contracts;

interface CacheServiceContract
{
    public function cacheNames(): void;
}