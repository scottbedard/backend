<?php

namespace Tests\Unit;

use Bedard\Backend\Components\Group;
use PHPUnit\Framework\TestCase;

class ComponentTest extends TestCase
{
    public function test_data_is_provided_to_all_descendent_components()
    {
        $grandchild = Group::make();

        $child = Group::items([ $grandchild ]);

        $parent = Group::items([ $child ]);

        $parent->provide(['foo' => 'bar']);
        
        $this->assertEquals('bar', $grandchild->data['foo']);
        $this->assertEquals('bar', $child->data['foo']);
        $this->assertEquals('bar', $parent->data['foo']);
    }
}
