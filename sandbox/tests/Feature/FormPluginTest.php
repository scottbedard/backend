<?php

namespace Tests\Unit;

use Bedard\Backend\Configuration\Backend;
use Bedard\Backend\Plugins\FormPlugin;
use Tests\TestCase;

class FormPluginTest extends TestCase
{
    public function test_forms_can_extend_other_forms()
    {
        $plugin = Backend::create(__DIR__ . '/stubs/_form_plugin.yaml')
            ->route('extension_grandchild')
            ->plugin();
                
        $this->assertEquals('qux', $plugin->get('fields.0.id'));
        $this->assertEquals('foo', $plugin->get('fields.1.id'));
        $this->assertEquals('baz', $plugin->get('fields.2.id'));
        $this->assertEquals('bar', $plugin->get('fields.3.id'));
        $this->assertEquals('grandchild', $plugin->get('fields.3.label'));
    }
}
