<?php

namespace Tests\Unit;

use Bedard\Backend\Configuration\Controller;
use Tests\TestCase;

class ConfigurationControllerTest extends TestCase
{
    public function test_filling_default_controller_values()
    {
        $config = Controller::create();

        $this->assertEquals([], $config->get('permissions'));
        $this->assertEquals([], $config->get('routes'));
        $this->assertEquals([], $config->get('subnav'));
    }
}
