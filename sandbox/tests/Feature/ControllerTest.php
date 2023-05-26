<?php

namespace Tests\Unit;

use Bedard\Backend\Configuration\Controller;
use Tests\TestCase;

class ControllerTest extends TestCase
{
    public function test_controller_sets_path_if_none_present()
    {
        $controller = Controller::create(['id' => 'foo_bar']);

        $this->assertEquals('foo-bar', $controller->get('path'));
    }

    public function test_controller_sets_default_null_path()
    {
        $controller = Controller::create(['id' => '_hello']);

        $this->assertNull($controller->get('path'));
    }

    public function test_controller_uses_null_path()
    {
        $controller = Controller::create(['id' => 'foo', 'path' => null]);

        $this->assertNull($controller->get('path'));
    }

    public function test_controller_uses_explicit_path()
    {
        $controller = Controller::create(['id' => 'foo', 'path' => 'bar']);

        $this->assertEquals('bar', $controller->get('path'));
    }
}
