<?php

namespace Tests\Unit;

use Bedard\Backend\Components\Block;
use PHPUnit\Framework\TestCase;

class RenderableTest extends TestCase
{
    public function test_providing_data_to_child_items()
    {
        $grandchild = Block::make();

        $child = Block::items([
            $grandchild,
        ]);

        $parent = Block::items([
            $child,
        ]);

        $instance = $parent->provide(['foo' => 'bar']);

        $this->assertEquals($parent, $instance);
        $this->assertEquals('bar', $parent->data['foo']);
        $this->assertEquals('bar', $child->data['foo']);
        $this->assertEquals('bar', $grandchild->data['foo']);
    }
}
