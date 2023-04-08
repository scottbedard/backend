<?php

namespace Tests\Unit;

use Bedard\Backend\Facades\Backend;
use Bedard\Backend\Plugins\ListPlugin;
use Illuminate\Support\Arr;
use Tests\TestCase;

class ListPluginTest extends TestCase
{
    public function test_creating_a_list_plugin(): void
    {
        $plugin = new ListPlugin('backend.roles.index');

        $this->assertInstanceOf(ListPlugin::class, $plugin);
        $this->assertEquals('roles', $plugin->id);
        $this->assertEquals('backend.roles.index', $plugin->route);
    }

    public function test_normalizing_key_value_syntax()
    {
        $plugin = new ListPlugin('backend.roles.index');

        $this->assertTrue(Arr::isList($plugin->config['options']['schema']));
        $this->assertEquals('id', $plugin->config['options']['schema'][0]['id']);
    }
}
