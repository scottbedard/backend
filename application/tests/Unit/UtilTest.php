<?php

namespace Tests\Unit;

use Bedard\Backend\Util;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Model;

class UtilTest extends TestCase
{
    public function test_get_id()
    {
        $this->assertEquals(5, Util::getId(new class extends Model {
            public $attributes = ['id' => 5];
        }));

        $this->assertEquals(5, Util::getId(5));

        $this->assertEquals(5, Util::getId('5'));
    }

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
