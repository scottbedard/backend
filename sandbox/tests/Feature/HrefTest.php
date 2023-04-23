<?php

namespace Tests\Unit;

use Bedard\Backend\Classes\Href;
use Tests\TestCase;

class HrefTest extends TestCase
{
    public function test_href_from_route_name()
    {
        $this->assertEquals(route('backend.admin.users'), Href::format('backend.admin.users'));
    }

    public function test_replace_backend_placeholder()
    {
        $backend = config('backend.path');

        $this->assertEquals("foo/{$backend}/bar", Href::format('foo/{backend}/bar'));
    }

    public function test_replace_controller_placeholder()
    {
        $this->assertEquals('foo/users/bar', Href::format('foo/{controller}/bar', 'users'));
    }

    public function test_replace_null_controller_placeholder()
    {
        $this->assertEquals('foo/bar', Href::format('foo/{controller}/bar', null));
        $this->assertEquals('bar', Href::format('{controller}/bar', null));
        $this->assertEquals('foo', Href::format('foo/{controller}', null));
    }
}
