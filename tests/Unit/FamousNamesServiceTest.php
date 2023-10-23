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
        // Create a mock object for the CacheContract interface
        $mockedCache = \Mockery::mock(CacheContract::class);

        // Set up the expected behavior for the has() method of the mock object
        $mockedCache->shouldReceive('has')
            ->with('famous-names')
            ->once()
            ->andReturn(false);

        // Set up the expected behavior for the put() method of the mock object
        $mockedCache->shouldReceive('put')
            ->once();

        // Set up the expected behavior for the get() method of the mock object
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

        // Create a mock object for the StorageContract interface
        $mockedStorage = \Mockery::mock(StorageContract::class);

        // Set up the expected behavior for the get() method of the mock object
        $mockedStorage
            ->shouldReceive('get')
            ->with('famous-names.json')
            ->once();

        // Create a new instance of the FamousNamesService class, passing in the mock objects
        $service = new FamousNamesService($mockedCache, $mockedStorage);

        // Call the getNames() method of the service object
        $names = $service->getNames();

        // Assert that the returned value is an array
        $this->assertIsArray($names);

        // Assert that the returned array has one element
        $this->assertCount(1, $names);

        // Assert that the first element of the returned array has an 'id' key with a value of 1
        $this->assertEquals(1, $names[0]['id']);

        // Assert that the first element of the returned array has a 'name' key with a value of 'John Smith'
        $this->assertEquals('John Smith', $names[0]['name']);
    }

    public function test_it_updates_a_name()
    {
        // Define an array of cache data
        $cacheData = [
            [
                "id" => 1,
                "name" => "John Smith",
                "location" => ["lat" => 53.883441, "lng" => -1.262003]
            ]
        ];

        // Create a mock object of the CacheContract interface
        $mockedCache = \Mockery::mock(CacheContract::class);

        // Set an expectation that the 'has' method will be called with 'famous-names' and return true
        $mockedCache->shouldReceive('has')
            ->with('famous-names')
            ->andReturn(true);

        // Set an expectation that the 'put' method will be called with 'famous-names' and a closure that updates the $cacheData variable
        $mockedCache->shouldReceive('put')
            ->with('famous-names', \Mockery::on(function ($value) use (&$cacheData) {
                $cacheData = $value;
                return true;
            }), 60);

        // Set an expectation that the 'get' method will be called with 'famous-names' and return the $cacheData variable
        $mockedCache->shouldReceive('get')->with('famous-names')
            ->andReturnUsing(function () use (&$cacheData) {
                return $cacheData;
            });

        // Create a mock object of the StorageContract interface
        $mockedStorage = \Mockery::mock(StorageContract::class);

        // Create an instance of the FamousNamesService class with the mocked cache and storage objects
        $service = new FamousNamesService($mockedCache, $mockedStorage);

        // Define an array of updated name data
        $updatedName = [
            'id' => 1,
            'name' => 'Jane Smith',
            'location' => ['lat' => 53.883441, 'lng' => -1.262003]
        ];

        // Call the updateName method of the FamousNamesService class with the id of 1 and an array of updated name data
        $service->updateName(1, ['name' => 'Jane Smith']);

        // Get the names from the mocked cache and assert that the first name in the array matches the updated name data
        $names = $mockedCache->get('famous-names');
        $this->assertEquals($updatedName, $names[0]);
    }


    public function test_it_deletes_a_name()
    {
        // Define an array of cache data
        $cacheData = [
            [
                "id" => 1,
                "name" => "John Smith",
                "location" => ["lat" => 53.883441, "lng" => -1.262003]
            ]
        ];

        // Create a mock object of the CacheContract interface using Mockery
        $mockedCache = \Mockery::mock(CacheContract::class);

        // Set an expectation that the 'has' method will be called with 'famous-names' and return true
        $mockedCache->shouldReceive('has')
            ->with('famous-names')
            ->andReturn(true);

        // Set an expectation that the 'put' method will be called with 'famous-names' and a closure that updates the $cacheData variable
        $mockedCache->shouldReceive('put')
            ->with('famous-names', \Mockery::on(function ($value) use (&$cacheData) {
                $cacheData = $value;
                return true;
            }), 60);

        // Set an expectation that the 'get' method will be called with 'famous-names' and return the $cacheData variable
        $mockedCache->shouldReceive('get')->with('famous-names')
            ->andReturnUsing(function () use (&$cacheData) {
                return $cacheData;
            });

        // Create a mock object of the StorageContract interface using Mockery
        $mockedStorage = \Mockery::mock(StorageContract::class);

        // Create a new instance of the FamousNamesService class using the mock cache and storage objects
        $service = new FamousNamesService($mockedCache, $mockedStorage);

        // Call the deleteName method of the service object with the argument 1
        $service->deleteName(1);

        // Get the list of names from the service object
        $names = $service->getNames();

        // Assert that the list of names is empty
        $this->assertEmpty($names);
    }
}
