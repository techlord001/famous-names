<?php

namespace Tests\Unit;

use App\Contracts\CacheServiceContract;
use App\Services\FamousNamesService;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class FamousNamesServiceTest extends TestCase
{
    public function test_it_retrieves_names_from_json()
    {
        // Mocking the Cache facade to return the names array
        Cache::shouldReceive('has')
            ->once()
            ->with('famous-names')
            ->andReturn(false);

        Cache::shouldReceive('get')
            ->once()
            ->with('famous-names')
            ->andReturn([
                [
                    "id" => 1,
                    "name" => "John Smith",
                    "location" => ["lat" => 53.883441, "lng" => -1.262003]
                ]
            ]);

        // Mocking the FamousNamesCacheService
        $cacheServiceMock = \Mockery::mock(CacheServiceContract::class);
        $cacheServiceMock->shouldReceive('cacheNames')->once();

        $service = new FamousNamesService($cacheServiceMock);

        $names = $service->getNames();

        $this->assertIsArray($names);
        $this->assertCount(1, $names);
        $this->assertEquals(1, $names[0]['id']);
        $this->assertEquals('John Smith', $names[0]['name']);
    }

    public function test_it_updates_a_name()
    {
        $cacheData = [
            [
                "id" => 1,
                "name" => "John Smith",
                "location" => ["lat" => 53.883441, "lng" => -1.262003]
            ]
        ];

        // Mocking the Cache facade to return the names array
        Cache::shouldReceive('has')
            ->with('famous-names')
            ->andReturn(true);

        Cache::shouldReceive('get')
            ->with('famous-names')
            ->andReturnUsing(function () use (&$cacheData) {
                return $cacheData;
            });

        Cache::shouldReceive('put')
            ->with('famous-names', \Mockery::on(function ($value) use (&$cacheData) {
                $cacheData = $value;
                return true;
            }), 60);
        
        $cacheService = \Mockery::mock(CacheServiceContract::class);
        $service = new FamousNamesService($cacheService);

        $updatedName = [
            'id' => 1,
            'name' => 'Jane Smith',
            'location' => ['lat' => 53.883441, 'lng' => -1.262003]
        ];

        $service->updateName(1, ['name' => 'Jane Smith']);

        $names = Cache::get('famous-names');
        $this->assertEquals($updatedName, $names[0]);
    }


    public function test_it_deletes_a_name()
    {
        $cacheData = [
            [
                "id" => 1,
                "name" => "John Smith",
                "location" => ["lat" => 53.883441, "lng" => -1.262003]
            ]
        ];

        // Mocking the Cache facade to return the names array
        Cache::shouldReceive('has')
            ->with('famous-names')
            ->andReturn(true);

        Cache::shouldReceive('get')
            ->with('famous-names')
            ->andReturnUsing(function () use (&$cacheData) {
                return $cacheData;
            });

        Cache::shouldReceive('put')
            ->once()
            ->with('famous-names', \Mockery::on(function ($value) use (&$cacheData) {
                $cacheData = $value;
                return is_array($value);
            }), 60);

        $cacheService = \Mockery::mock(CacheServiceContract::class);
        $service = new FamousNamesService($cacheService);

        $service->deleteName(1);

        $names = $service->getNames();

        $this->assertEmpty($names);
    }
}
