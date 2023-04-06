<?php

namespace Tests\Unit;

use Bedard\Backend\Facades\Backend;
use Bedard\Backend\Plugins\ListPlugin;
use Tests\TestCase;

class ListPluginTest extends TestCase
{
    public function test_creating_a_list_plugin(): void
    {
        $controllers = Backend::controllers();

        $plugin = new ListPlugin(
            config: Backend::config('backend.roles.index'),
            controllers: $controllers,
            id: 'roles',
            route: 'backend.roles.index',
        );

        $this->assertInstanceOf(ListPlugin::class, $plugin);
    }
}
