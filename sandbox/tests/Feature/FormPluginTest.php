<?php

namespace Tests\Unit;

use Bedard\Backend\Classes\Backend;
use Bedard\Backend\Classes\Href;
use Bedard\Backend\Facades\Backend as BackendFacade;
use Bedard\Backend\Plugins\FormPlugin;
use Tests\TestCase;

class FormPluginTest extends TestCase
{
    public function test_associative_form_fields()
    {
        $backend = Backend::from(__DIR__ . '/stubs/_form_field_normalization.yaml');
        $route = 'backend._form_field_normalization.associative_fields';
        BackendFacade::shouldReceive('controller')->andReturn($backend->controller($route));
        BackendFacade::shouldReceive('route')->andReturn($backend->route($route));

        $form = new FormPlugin($route);
        
        $this->assertEquals('first', $form->option('fields.0.id'));
        $this->assertEquals('second', $form->option('fields.1.id'));
    }

    public function test_sequential_form_fields()
    {
        $backend = Backend::from(__DIR__ . '/stubs/_form_field_normalization.yaml');
        $route = 'backend._form_field_normalization.sequential_fields';
        BackendFacade::shouldReceive('controller')->andReturn($backend->controller($route));
        BackendFacade::shouldReceive('route')->andReturn($backend->route($route));

        $form = new FormPlugin($route);
        
        $this->assertEquals('foo', $form->option('fields.0.id'));
        $this->assertEquals('bar', $form->option('fields.1.id'));
    }
}
