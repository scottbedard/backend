<?php

namespace Tests\Unit;

use Bedard\Backend\Classes\UrlPath;
use Exception;
use PHPUnit\Framework\TestCase;

class UrlPathTest extends TestCase
{
    public function test_valid_url_paths(): void
    {
        $paths = [
            '/',
            'foo',
            'foo/bar',
            'foo/{bar}',
            'foo/{bar?}',
            '/foo',
            '/foo/bar',
            '/foo/{bar}',
            '/foo/{bar?}',
            '{foo}',
            '{foo?}',
            '{foo}/{bar}',
            '{foo}/{bar?}',
            '/{foo}',
            '/{foo?}',
            '/{foo}/{bar}',
            '/{foo}/{bar?}',
        ];

        foreach ($paths as $path) {
            $valid = UrlPath::validate($path);

            if (!$valid) {
                $this->fail('Invalid path: ' . $path);

                return;
            }

            $this->assertTrue($valid);
        }
    }

    public function test_invalid_url_paths()
    {
        $paths = [
            '',
            '//',
            'disallow whitespace',
            '$trange-ch@racters',
            '{backwards}/segment',
            '{backwards?}/{optional}',
            '{double?}/{optional?}',
            'double//slashe',
            'trailing/slash/',
        ];

        foreach ($paths as $path) {
            $valid = UrlPath::validate($path);

            if ($valid) {
                $this->fail('False-valid path: ' . $path);

                return;
            }

            $this->assertFalse($valid);
        }
    }

    public function test_parsing_segments()
    {
        $up = new UrlPath('foo/{bar}/{baz?}');

        $this->assertEquals($up->segments, [
            [
                'name' => 'foo',
                'optional' => false,
                'param' => false,
            ],
            [
                'name' => 'bar',
                'optional' => false,
                'param' => true,
            ],
            [
                'name' => 'baz',
                'optional' => true,
                'param' => true,
            ],
        ]);
    }
}
