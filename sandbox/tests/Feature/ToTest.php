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

    public function test_to_interpolate_href_data()
    {
        $backend = Backend::create(__DIR__ . '/stubs/to');

        $href = To::href(
            backend: $backend,
            controller: 'foo',
            route: 'bar',
            to: ':backend/:controller/:route/edit/{id}',
            data: ['id' => 123],
        );
        
        $this->assertEquals(url('backend/foo/bar/edit/123'), $href);
    }
}
