<?php

namespace Tests\Unit;

use Bedard\Backend\Classes\Backend;
use Bedard\Backend\Classes\Href;
use Bedard\Backend\Facades\Backend as BackendFacade;
use Bedard\Backend\Form\TextField;
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
            stubs: __DIR__ . '/stubs/_form_plugin.yaml',
            route: 'backend._form_plugin.blank_field',
        );

        // first field
        $this->assertEquals(false, $form->option('fields.0.disabled'));
        $this->assertEquals('Foo', $form->option('fields.0.label'));
        $this->assertEquals(TextField::class, $form->option('fields.0.type'));

        // second field
        $this->assertEquals(null, $form->option('fields.1.label'));
    }

    public function test_associative_form_fields()
    {
        $form = $this->form(
            stubs: __DIR__ . '/stubs/_form_plugin.yaml',
            route: 'backend._form_plugin.associative_fields',
        );
        
        $this->assertEquals('first', $form->option('fields.0.id'));
        $this->assertEquals('second', $form->option('fields.1.id'));
    }

    public function test_sequential_form_fields()
    {
        $form = $this->form(
            stubs: __DIR__ . '/stubs/_form_plugin.yaml',
            route: 'backend._form_plugin.sequential_fields',
        );
        
        $this->assertEquals('foo', $form->option('fields.0.id'));
        $this->assertEquals('bar', $form->option('fields.1.id'));
    }

    public function test_forms_can_extend_other_forms()
    {
        $form = $this->form(
            stubs: __DIR__ . '/stubs/_form_plugin.yaml',
            route: 'backend._form_plugin.extention_child',
        );

        $this->assertEquals('foo', $form->option('fields.0.id'));
        $this->assertEquals('baz', $form->option('fields.1.id'));
        $this->assertEquals('bar', $form->option('fields.2.id'));
        $this->assertEquals('hello', $form->option('fields.2.label'));
    }

    public function test_form_field_spans()
    {
        $form = $this->form(
            stubs: __DIR__ . '/stubs/_form_plugin.yaml',
            route: 'backend._form_plugin.field_spans',
        );
        
        $this->assertEquals([
            'xs' => 12,
            'sm' => 12,
            'md' => 12,
            'lg' => 6,
            'xl' => 6,
            '2xl' => 6,
        ], $form->option('fields.0.span'));

        $this->assertEquals([
            'xs' => 12,
            'sm' => 12,
            'md' => 6,
            'lg' => 4,
            'xl' => 4,
            '2xl' => 4,
        ], $form->option('fields.1.span'));
    }

    public function test_field_type_default_and_aliases()
    {
        $form = $this->form(
            stubs: __DIR__ . '/stubs/_form_plugin.yaml',
            route: 'backend._form_plugin.field_aliases',
        );
        
        $this->assertEquals('Bedard\Backend\Form\TextField', $form->option('fields.0.type'));
        $this->assertEquals('Bedard\Backend\Form\EmailField', $form->option('fields.1.type'));
        $this->assertEquals('Bedard\Backend\Form\NumberField', $form->option('fields.2.type'));
        $this->assertEquals('Bedard\Backend\Form\TextField', $form->option('fields.3.type'));
    }
}
