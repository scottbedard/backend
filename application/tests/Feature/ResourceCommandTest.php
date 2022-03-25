<?php

namespace Tests\Feature;

use Backend;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ResourceCommandTest extends TestCase
{
    public $testFiles = [
        'app/Backend/Resources/TestResource.php',
    ];

    /**
     * Test creating a resource.
     *
     * @return void
     */
    public function test_creating_a_resource()
    {
        $path = base_path('app/Backend/Resources/TestResource.php');

        $this->assertFileDoesNotExist($path);

        Artisan::call('backend:resource Test');

        $this->assertFileExists($path);

        $resource = Arr::first(Backend::resources(), function ($r) {
            return $r['className'] === 'App\Backend\Resources\TestResource';
        });

        $this->assertEquals('App\Models\Test', $resource['model']);
        $this->assertEquals('tests', $resource['route']);
        $this->assertEquals('Tests', $resource['title']);
        $this->assertEquals(0, $resource['order']);
    }
}
