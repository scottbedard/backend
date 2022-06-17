<?php

namespace Tests\Feature\Console;

use Backend;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ActionCommandTest extends TestCase
{
    public $testFiles = [
        'app/Backend/Actions/TestAction.php',
    ];

    public function test_creating_an_action()
    {
        $path = base_path('app/Backend/Actions/TestAction.php');

        $this->assertFileDoesNotExist($path);

        Artisan::call('backend:action Test');

        $this->assertFileExists($path);
    }
}
