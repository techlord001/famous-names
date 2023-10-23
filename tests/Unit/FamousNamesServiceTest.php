<?php

namespace Tests\Unit;

use App\Contracts\CacheContract;
use App\Contracts\StorageContract;
use App\Services\FamousNamesService;
use Tests\TestCase;

class FamousNamesServiceTest extends TestCase
{
    public function test_it_retrieves_names_from_json()
    {
        // Arrange
        $mockedCache = \Mockery::mock(CacheContract::class);

        $mockedCache->shouldReceive('has')
            ->with('famous-names')
            ->once()
            ->andReturn(false);
        $mockedCache->shouldReceive('put')
            ->once();
        $mockedCache->shouldReceive('get')
            ->with('famous-names')
            ->once()
            ->andReturn([
                [
                    "id" => 1,
                    "name" => "John Smith",
                    "location" => ["lat" => 53.883441, "lng" => -1.262003]
                ]
            ]);

        $mockedStorage = \Mockery::mock(StorageContract::class);
        $mockedStorage
            ->shouldReceive('get')
            ->with('famous-names.json')
            ->once();

        $service = new FamousNamesService($mockedCache, $mockedStorage);

        // Act
        $names = $service->getNames();

        // Assert
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

        $mockedCache = \Mockery::mock(CacheContract::class);

        $mockedCache->shouldReceive('has')
            ->with('famous-names')
            ->andReturn(true);

        $mockedCache->shouldReceive('put')
            ->with('famous-names', \Mockery::on(function ($value) use (&$cacheData) {
                $cacheData = $value;
                return true;
            }), 60);

        $mockedCache->shouldReceive('get')->with('famous-names')
            ->andReturnUsing(function () use (&$cacheData) {
                return $cacheData;
            });

        $mockedStorage = \Mockery::mock(StorageContract::class);

        $service = new FamousNamesService($mockedCache, $mockedStorage);

        $updatedName = [
            'id' => 1,
            'name' => 'Jane Smith',
            'location' => ['lat' => 53.883441, 'lng' => -1.262003]
        ];

        $service->updateName(1, ['name' => 'Jane Smith']);

        $names = $mockedCache->get('famous-names');
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

        $mockedCache = \Mockery::mock(CacheContract::class);

        $mockedCache->shouldReceive('has')
            ->with('famous-names')
            ->andReturn(true);

        $mockedCache->shouldReceive('put')
            ->with('famous-names', \Mockery::on(function ($value) use (&$cacheData) {
                $cacheData = $value;
                return true;
            }), 60);

        $mockedCache->shouldReceive('get')->with('famous-names')
            ->andReturnUsing(function () use (&$cacheData) {
                return $cacheData;
            });

        $mockedStorage = \Mockery::mock(StorageContract::class);

        $service = new FamousNamesService($mockedCache, $mockedStorage);

        $service->deleteName(1);

        $names = $service->getNames();

        $this->assertEmpty($names);
    }
}
