<?php

namespace Tests\Unit;

use Bedard\Backend\Classes\Backend;
use Bedard\Backend\Classes\Href;
use Bedard\Backend\Facades\Backend as BackendFacade;
use Bedard\Backend\Plugins\FormPlugin;
use Tests\TestCase;

class FormPluginTest extends TestCase
{
    private function form($stubs, $route)
    {
        $backend = Backend::from($stubs);
        BackendFacade::shouldReceive('controller')->andReturn($backend->controller($route));
        BackendFacade::shouldReceive('route')->andReturn($backend->route($route));

        return new FormPlugin($route);
    }

    public function test_filling_blank_field_values()
    {
        $form = $this->form(
            stubs: __DIR__ . '/stubs/_form_field_normalization.yaml',
            route: 'backend._form_field_normalization.blank_field',
        );

        // first field
        $this->assertEquals(false, $form->option('fields.0.disabled'));
        $this->assertEquals('Foo', $form->option('fields.0.label'));

        // second field
        $this->assertEquals(null, $form->option('fields.1.label'));
    }

    public function test_associative_form_fields()
    {
        $form = $this->form(
            stubs: __DIR__ . '/stubs/_form_field_normalization.yaml',
            route: 'backend._form_field_normalization.associative_fields',
        );
        
        $this->assertEquals('first', $form->option('fields.0.id'));
        $this->assertEquals('second', $form->option('fields.1.id'));
    }

    public function test_sequential_form_fields()
    {
        $form = $this->form(
            stubs: __DIR__ . '/stubs/_form_field_normalization.yaml',
            route: 'backend._form_field_normalization.sequential_fields',
        );
        
        $this->assertEquals('foo', $form->option('fields.0.id'));
        $this->assertEquals('bar', $form->option('fields.1.id'));
    }

    public function test_forms_can_extend_other_forms()
    {
        $form = $this->form(
            stubs: __DIR__ . '/stubs/_form_field_normalization.yaml',
            route: 'backend._form_field_normalization.extention_child',
        );

        $this->assertEquals('foo', $form->option('fields.0.id'));
        $this->assertEquals('baz', $form->option('fields.1.id'));
        $this->assertEquals('bar', $form->option('fields.2.id'));
        $this->assertEquals('hello', $form->option('fields.2.label'));
    }
}
