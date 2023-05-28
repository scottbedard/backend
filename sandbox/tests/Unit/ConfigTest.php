<?php

namespace Tests\Unit;

use Bedard\Backend\Config\Config;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Classes\Child;
use Tests\Unit\Classes\Defaults;
use Tests\Unit\Classes\Grandchild;
use Tests\Unit\Classes\InheritsName;
use Tests\Unit\Classes\Noop;
use Tests\Unit\Classes\ParentConfig;
use Tests\Unit\Classes\ParentOfKeyedChildren;
use Tests\Unit\Classes\ParentOfManyChildren;
use Tests\Unit\Classes\ParentOfSingleChild;
use Tests\Unit\Traits\DynamicTestAttribute;

class ConfigTest extends TestCase
{
    public function test_static_config_constructor()
    {
        $this->assertInstanceOf(Noop::class, Noop::create());
    }

    public function test_config_overwrites_defaults()
    {
        $config = Defaults::create([
            'hello' => 'world',
            'overwrite' => 'new value',
        ]);

        $this->assertEquals([
            'foo' => 'bar',
            'hello' => 'world',
            'overwrite' => 'new value',
        ], $config->__config);
    }
    
    public function test_dynamic_default_values()
    {
        $config = new class extends Config
        {
            use DynamicTestAttribute;

            public function getDefaultConfig(): array
            {
                return [
                    'overwrite' => 'new value',
                ];
            }
        };

        $this->assertEquals([
            'overwrite' => 'new value',
            'test' => 'hello',
            'multi_word' => 'world',
        ], $config->__config);
    }

    public function test_custom_attribute_setter()
    {
        $config = new class extends Config
        {
            public function getDefaultConfig(): array
            {
                return [
                    'foo' => 'bar',
                    'multi_word' => 1,
                ];
            }

            public function getDefaultDynamicAttribute()
            {
                return 'hello';
            }

            public function setDynamicAttribute($value)
            {
                return $value . ' world';
            }

            public function setFooAttribute($value)
            {
                return strtoupper($value);
            }

            public function setMultiWordAttribute($value)
            {
                return $value * 2;
            }
        };

        $this->assertEquals([
            'dynamic' => 'hello world',
            'foo' => 'BAR',
            'multi_word' => 2,
        ], $config->__data);
    }

    public function test_parent_of_single_child()
    {
        $parent = ParentOfSingleChild::create([
            'child' => ['name' => 'alice'],
        ]);

        $this->assertInstanceOf(Noop::class, $parent->child);

        $this->assertEquals('alice', $parent->child->name);
    }

    public function test_parent_of_many_children()
    {
        $parent = ParentOfManyChildren::create([
            'children' => [
                ['name' => 'alice'],
                ['name' => 'bob'],
            ],
        ]);

        $this->assertEquals('alice', $parent->children[0]->name);

        $this->assertEquals('bob', $parent->children[1]->name);
    }

    public function test_parent_of_keyed_children()
    {
        $parent = ParentOfKeyedChildren::create([
            'keyed_children' => [
                'alice' => ['age' => 35],
                'bob' => ['age' => 40],
            ],
        ]);
        
        $this->assertEquals('alice', $parent->keyed_children[0]->name);
        $this->assertEquals(35, $parent->keyed_children[0]->age);

        $this->assertEquals('bob', $parent->keyed_children[1]->name);
        $this->assertEquals(40, $parent->keyed_children[1]->age);
    }

    public function test_parent_of_keyed_children_sequential()
    {
        $parent = ParentOfKeyedChildren::create([
            'keyed_children' => [
                ['name' => 'alice', 'age' => 35],
                ['name' => 'bob', 'age' => 40],
            ],
        ]);
        
        $this->assertEquals('alice', $parent->keyed_children[0]->name);
        $this->assertEquals(35, $parent->keyed_children[0]->age);

        $this->assertEquals('bob', $parent->keyed_children[1]->name);
        $this->assertEquals(40, $parent->keyed_children[1]->age);
    }

    public function test_inheriting_config_from_parent()
    {
        $config = new class extends Config
        {
            public function getDefaultConfig(): array
            {
                return [
                    'name' => 'alice',
                    'child' => [],
                    'children' => [
                        [],
                        ['name' => 'bob'],
                    ],
                    'keyed_children' => [
                        'foo' => [],
                        'bar' => ['name' => 'cindy'],
                    ]
                ];
            }

            public function getChildren(): array
            {
                return [
                    'child' => InheritsName::class,
                    'children' => [InheritsName::class],
                    'keyed_children' => [InheritsName::class, 'id'],
                ];
            }
        };
        
        $this->assertEquals('alice', $config->child->name);
        $this->assertEquals('alice', $config->children[0]->name);

        $this->assertEquals('alice', $config->children[0]->name);
        $this->assertEquals('alice', $config->children[0]->name);
        $this->assertEquals('bob', $config->children[1]->name);

        $this->assertEquals('alice', $config->keyed_children[0]->name);
        $this->assertEquals('cindy', $config->keyed_children[1]->name);
    }

    public function test_climbing_ancestor_tree()
    {
        $parent = ParentConfig::create([
            'child' => [
                'child' => [],
                'depth' => 1,
            ],
            'depth' => 0,
        ]);

        $grandchild = $parent->child->child;
        
        $this->assertInstanceOf(Child::class, $grandchild->climb(fn ($p) => $p->depth === 1));

        $this->assertInstanceOf(ParentConfig::class, $grandchild->climb(fn ($p) => $p->depth === 0));
    }

    public function test_accessing_closest_ancestor()
    {
        $parent = ParentConfig::create([
            'child' => [
                'child' => [],
            ],
        ]);

        $child = $parent->child;

        $grandchild = $parent->child->child;

        $this->assertInstanceOf(Child::class, $child);

        $this->assertEquals($parent, $child->closest(ParentConfig::class));

        $this->assertInstanceOf(Grandchild::class, $grandchild);

        $this->assertEquals($parent, $grandchild->closest(ParentConfig::class));

        $this->assertNull($parent->closest(Noop::class));
    }
}
