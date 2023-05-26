<?php

namespace Tests\Unit;

use Bedard\Backend\Classes\Href;
use Bedard\Backend\Configuration\Backend;
use Tests\TestCase;

class HrefTest extends TestCase
{
    public function test_href_from_backend_controller_route()
    {
        $url = Href::format(
            config: Backend::create(__DIR__ . '/stubs/books.yaml'),
            to: 'backend.books.create',
        );

        $this->assertEquals(url('backend/books/create'), $url);
    }

    public function test_replace_backend_placeholder()
    {
        $backend = config('backend.path');
        
        $this->assertEquals("foo/{$backend}", Href::format(
            to: 'foo/{backend}',
        ));

        $this->assertEquals("foo/{$backend}/bar", Href::format(
            to: 'foo/{backend}/bar',
        ));

        $this->assertEquals("{$backend}/bar", Href::format(
            to: '{backend}/bar',
        ));
    }

    public function test_replace_controller_placeholder()
    {
        $this->assertEquals('foo/users', Href::format(
            controller: 'users',
            to: 'foo/{controller}',
        ));

        $this->assertEquals('foo/users/bar', Href::format(
            controller: 'users',
            to: 'foo/{controller}/bar',
        ));

        $this->assertEquals('users/bar', Href::format(
            controller: 'users',
            to: '{controller}/bar',
        ));
    }

    // public function test_replace_null_controller_placeholder()
    // {
    //     $this->assertEquals('foo/bar', Href::format('foo/{controller}/bar', null));
    //     $this->assertEquals('bar', Href::format('{controller}/bar', null));
    //     $this->assertEquals('foo', Href::format('foo/{controller}', null));
    // }
}
