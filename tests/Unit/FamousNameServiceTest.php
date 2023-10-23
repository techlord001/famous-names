<?php

namespace Tests\Unit;

use App\Services\FamousNamesService;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FamousNamesServiceTest extends TestCase
{
    public function test_it_retrieves_names_from_json()
    {
        // Mocking the Storage facade to return a sample JSON string
        Storage::shouldReceive('get')
            ->once()
            ->with('famous-names.json')
            ->andReturn('{"famousNames":[{"id":1,"name":"John Smith","location":{"lat":53.883441,"lng":-1.262003}}]}');

        // Mocking the FamousNamesCacheService
        $cacheServiceMock = \Mockery::mock(FamousNamesCacheService::class);
        $cacheServiceMock->shouldReceive('cacheNames')->once();

        $service = new FamousNamesService($cacheServiceMock);

        $names = $service->getNames();

        $this->assertIsArray($names);
        $this->assertCount(1, $names);
        $this->assertEquals(1, $names[0]['id']);
        $this->assertEquals('John Smith', $names[0]['name']);
    }
}