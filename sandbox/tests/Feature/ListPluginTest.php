<?php

namespace Tests\Unit;

use Bedard\Backend\Classes\Backend;
use Bedard\Backend\Classes\Href;
use Bedard\Backend\Facades\Backend as BackendFacade;
use Bedard\Backend\Plugins\ListPlugin;
use Tests\TestCase;

class ListPluginTest extends TestCase
{
    private function list($stubs, $route)
    {
        $backend = Backend::from($stubs);
        BackendFacade::shouldReceive('controller')->andReturn($backend->controller($route));
        BackendFacade::shouldReceive('route')->andReturn($backend->route($route));

        return new ListPlugin($route);
    }

    public function test_associative_list_schema()
    {
        $list = $this->list(
            stubs: __DIR__ . '/stubs/_list_plugin.yaml',
            route: 'backend._list_plugin.schema_associative',
        );
        
        $this->assertEquals('foo', $list->option('schema.0.id'));
        $this->assertEquals('bar', $list->option('schema.1.id'));
    }

    public function test_sequential_schema()
    {
        $list = $this->list(
            stubs: __DIR__ . '/stubs/_list_plugin.yaml',
            route: 'backend._list_plugin.schema_sequential',
        );
        
        $this->assertEquals('foo', $list->option('schema.0.id'));
        $this->assertEquals('bar', $list->option('schema.1.id'));
    }

    public function test_row_to_keyword_replacement()
    {
        $list = $this->list(
            stubs: __DIR__ . '/stubs/_list_plugin.yaml',
            route: 'backend._list_plugin.row_to_keyword_replacement',
        );

        $this->assertEquals('/backend/list-plugin/{id}', $list->option('row_to'));
    }
}
