<?php

namespace Tests\Unit;

use Bedard\Backend\Classes\ArrayUtil;
use PHPUnit\Framework\TestCase;

class ArrayUtilTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_merge_by(): void
    {
        $parent = [
            ['id' => 'foo', 'name' => 'Parent Foo'],
            ['id' => 'bar', 'name' => 'Parent Bar'],
        ];

        $child = [
            ['id' => 'foo', 'name' => 'Child Foo'],
            ['id' => 'baz', 'name' => 'Child Baz'],
        ];

        $merged = ArrayUtil::mergeBy($parent, $child, 'id');

        $this->assertEquals([
            ['id' => 'foo', 'name' => 'Child Foo'],
            ['id' => 'bar', 'name' => 'Parent Bar'],
            ['id' => 'baz', 'name' => 'Child Baz'],
        ], $merged);
    }
}
