<?php

namespace Tests\Unit;

use Bedard\Backend\Classes\Plugin;
use Tests\TestCase;

class PluginTest extends TestCase
{
    public function test_creating_a_plugin_with_missing_params(): void
    {
        $this->expectException(\Exception::class);

        new Plugin([
            // ...
        ]);
    }
}
