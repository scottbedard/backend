<?php

namespace Tests\Unit;

use Bedard\Backend\Util;
use PHPUnit\Framework\TestCase;

class UtilTest extends TestCase
{
    public function test_string_suggest()
    {
        // array
        $this->assertEquals('foo', Util::suggest('fooz', ['foo', 'bar', 'baz']));

        // collection
        $this->assertEquals('foo', Util::suggest('fooz', collect(['foo', 'bar', 'baz'])));

        // normalized
        $this->assertEquals('FOO', Util::suggest('fooz', ['foo', 'bar', 'baz'], 'strtoupper'));
    }
}
