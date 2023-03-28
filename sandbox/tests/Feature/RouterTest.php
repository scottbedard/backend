<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Bedard\Backend\BackendController;
use Bedard\Backend\Classes\Router;
use Tests\TestCase;

class RouterTest extends TestCase
{
    public function test_parsing_url()
    {
        $router = new Router();
        
        $url = $router->parse('/foo/bar/baz?one=two&three=four#hello');

        $this->assertEquals($url, [
            'fragment' => 'hello',
            'path' => 'foo/bar/baz',
            'query' => [
                'one' => 'two',
                'three' => 'four',
            ],
        ]);
    }

    public function test_routing_to_an_index_method(): void
    {
        $router = new Router([
            'things' => [
                'routes' => [
                    'index' => ['path' => '/'],
                    'create' => ['path' => 'create'],
                ], 
            ],
            'users' => [
                'routes' => [
                    'index' => ['path' => '/'],
                    'create' => ['path' => 'create'],
                ], 
            ],
        ]);

        $this->assertEquals('users.routes.index', $router->resolve('/backend/users'));
    }
}
