<?php

namespace Tests\Feature;

use Bedard\Backend\Classes\To;
use Bedard\Backend\Config\Backend;
use Tests\TestCase;

class ToTest extends TestCase
{
    public function test_to_named_route()
    {
        $href = To::href('status.200');

        $this->assertEquals(url('200'), $href);
    }

    public function test_to_backend_route()
    {
        $backend = Backend::create(__DIR__ . '/stubs/to');
        
        $href = To::href('backend.foo.bar', $backend);

        $this->assertEquals(url('/backend/foo/bar'), $href);
    }
}
