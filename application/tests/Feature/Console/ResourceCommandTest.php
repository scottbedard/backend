<?php

namespace Tests\Feature\Console;

use Backend;
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

        $resource = Backend::resource('tests');

        $this->assertEquals('App\Models\Test', $resource::$model);
        $this->assertEquals('tests', $resource::$id);
        $this->assertEquals('Tests', $resource::$title);
        $this->assertEquals(0, $resource::$order);
    }
}
