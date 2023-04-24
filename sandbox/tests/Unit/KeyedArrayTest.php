<?php

namespace Tests\Unit;

use Bedard\Backend\Classes\KeyedArray;
use PHPUnit\Framework\TestCase;

class KeyedArrayTest extends TestCase
{
    public function test_keyed_array_with_null()
    {
        $source = [
            'foo' => null,
        ];

        $this->assertEquals([
            [
                'id' => 'foo',
            ],
        ], KeyedArray::of($source, 'id'));
    }

    public function test_keyed_array_from_associative(): void
    {
        $source = [
            'foo' => [
                'value' => 1,
            ],
            'bar' => [
                'value' => 2,
            ],
        ];

        $this->assertEquals([
            [
                'id' => 'foo', 
                'value' => 1,
            ],
            [
                'id' => 'bar', 
                'value' => 2,
            ],
        ], KeyedArray::of($source, 'id'));
    }

    public function test_keyed_array_from_sequential()
    {
        $source = [
            [
                'id' => 'foo', 
                'value' => 1,
            ],
            [
                'id' => 'bar', 
                'value' => 2,
            ],
        ];

        $this->assertEquals([
            [
                'id' => 'foo', 
                'value' => 1,
            ],
            [
                'id' => 'bar', 
                'value' => 2,
            ],
        ], KeyedArray::of($source, 'id'));
    }
}
