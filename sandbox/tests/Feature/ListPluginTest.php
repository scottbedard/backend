<?php

namespace Tests\Unit;

use Bedard\Backend\Configuration\Backend;
use Bedard\Backend\Plugins\ListPlugin;
use Tests\TestCase;

class ListPluginTest extends TestCase
{
    public function test_row_to_parsing()
    {
        $opts = Backend::create(__DIR__ . '/stubs/_list_plugin.yaml')
            ->route('parse_row_to')
            ->plugin()
            ->options();
            
        $this->assertEquals('/backend/list-plugin/users/{id}', $opts['row_to']);
    }
}
