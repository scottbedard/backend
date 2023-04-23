<?php

namespace Tests\Unit;

use Bedard\Backend\Classes\Backend;
use Bedard\Backend\Classes\Href;
use Bedard\Backend\Facades\Backend as BackendFacade;
use Bedard\Backend\Plugins\ListPlugin;
use Tests\TestCase;

class ListPluginTest extends TestCase
{
    public function test_row_to_keyword_replacement()
    {
        $route = 'backend._list_row_to.show';
        $backend = Backend::from(__DIR__ . '/stubs/_list_row_to.yaml');
        BackendFacade::shouldReceive('controller')->andReturn($backend->controller($route));
        BackendFacade::shouldReceive('route')->andReturn($backend->route($route));

        $list = new ListPlugin($route);
        $this->assertEquals('/backend/users/{id}', $list->option('row_to'));
    }
}
