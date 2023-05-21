<?php

namespace Tests\Unit;

use Bedard\Backend\Configuration\Backend;
use Bedard\Backend\Form\Field;
use Bedard\Backend\Form\InputField;
use Bedard\Backend\Plugins\FormPlugin;
use Tests\Feature\Classes\FieldStub;
use Tests\TestCase;

class FormPluginTest extends TestCase
{
    public function test_forms_can_extend_other_forms()
    {
        // parent
        $parent = Backend::create(__DIR__ . '/stubs/_form_plugin.yaml')
            ->route('extension_parent')
            ->plugin();

        $this->assertEquals(2, $parent->get('fields')->count());
        $this->assertInstanceOf(Field::class, $parent->get('fields.0'));
        $this->assertInstanceOf(Field::class, $parent->get('fields.1'));
        $this->assertEquals('foo', $parent->get('fields.0.id'));
        $this->assertEquals('bar', $parent->get('fields.1.id'));

        // child
        $child = Backend::create(__DIR__ . '/stubs/_form_plugin.yaml')
            ->route('extension_child')
            ->plugin();

        $this->assertEquals(3, $child->get('fields')->count());
        $this->assertInstanceOf(Field::class, $child->get('fields.0'));
        $this->assertInstanceOf(Field::class, $child->get('fields.1'));
        $this->assertInstanceOf(Field::class, $child->get('fields.2'));
        $this->assertEquals('foo', $child->get('fields.0.id'));
        $this->assertEquals('baz', $child->get('fields.1.id'));
        $this->assertEquals('bar', $child->get('fields.2.id'));
               
        // grandchild
        $grandchild = Backend::create(__DIR__ . '/stubs/_form_plugin.yaml')
            ->route('extension_grandchild')
            ->plugin(); 

        $this->assertEquals(4, $grandchild->get('fields')->count());
        $this->assertInstanceOf(Field::class, $grandchild->get('fields.0'));
        $this->assertInstanceOf(Field::class, $grandchild->get('fields.1'));
        $this->assertInstanceOf(Field::class, $grandchild->get('fields.2'));
        $this->assertInstanceOf(Field::class, $grandchild->get('fields.3'));
        $this->assertEquals('qux', $grandchild->get('fields.0.id'));
        $this->assertEquals('foo', $grandchild->get('fields.1.id'));
        $this->assertEquals('baz', $grandchild->get('fields.2.id'));
        $this->assertEquals('bar', $grandchild->get('fields.3.id'));
        $this->assertEquals('grandchild', $grandchild->get('fields.3.label'));
    }

    public function test_forms_generate_column_spans()
    {
        $plugin = Backend::create(__DIR__ . '/stubs/_form_plugin.yaml')
            ->route('field_spans')
            ->plugin();
            
        $this->assertEquals([
            'xs' => 12,
            'sm' => 12,
            'md' => 12,
            'lg' => 6,
            'xl' => 6,
            '2xl' => 6,
        ], $plugin->get('fields.0.span'));
        
        $this->assertEquals([
            'xs' => 12,
            'sm' => 12,
            'md' => 6,
            'lg' => 4,
            'xl' => 4,
            '2xl' => 4,
        ], $plugin->get('fields.1.span'));
    }

    public function test_fields_set_default_label_when_not_null()
    {
        $plugin = Backend::create(__DIR__ . '/stubs/_form_plugin.yaml')
            ->route('default_labels')
            ->plugin();
            
        $this->assertEquals('One Two', $plugin->get('fields.0.label'));
        $this->assertNull($plugin->get('fields.1.label'));
    }

    public function test_fields_subclasses()
    {
        $plugin = Backend::create(__DIR__ . '/stubs/_form_plugin.yaml')
            ->route('field_stub')
            ->plugin();
            
        $this->assertInstanceOf(FieldStub::class, $plugin->get('fields.0'));

        $this->assertInstanceOf(InputField::class, $plugin->get('fields.1'));

        $this->assertInstanceOf(InputField::class, $plugin->get('fields.2'));
    }

    public function test_validation_error_path()
    {
        $plugin = Backend::create(__DIR__ . '/stubs/_form_plugin.yaml')
            ->route('validation_error_path')
            ->plugin();

        $this->assertEquals(
            'controllers._form_plugin.routes.validation_error_path.options.fields.foo',
            $plugin->get('fields.0')->getConfigurationPath()
        );
    }
}
