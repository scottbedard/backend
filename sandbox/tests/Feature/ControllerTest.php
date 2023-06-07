<?php

namespace Tests\Feature;

use Bedard\Backend\Config\Controller;
use Bedard\Backend\Exceptions\ConfigValidationException;
use Tests\TestCase;

class ControllerTest extends TestCase
{
    public function test_controller_uses_null_path()
    {
        $controller = Controller::create(['id' => 'foo', 'path' => null]);

        $this->assertNull($controller->path);
    }

    public function test_controller_uses_explicit_path()
    {
        $controller = Controller::create(['id' => 'foo', 'path' => 'bar']);

        $this->assertEquals('bar', $controller->path);
    }

    public function test_path_must_be_alpha_dash_string()
    {
        $controller = new class extends Controller
        {
            public function getDefaultConfig(): array
            {
                return [
                    'path' => 'some',
                ];
            }
        };

        $this->expectException(ConfigValidationException::class);

        $controller->validate();
    }
}
