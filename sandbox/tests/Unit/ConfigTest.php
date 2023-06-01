<?php

namespace Tests\Unit;

use Bedard\Backend\Config\Config;
use Bedard\Backend\Exceptions\ConfigurationException;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Classes\CatchphraseBehavior;
use Tests\Unit\Classes\Child;
use Tests\Unit\Classes\DefaultConfigBehavior;
use Tests\Unit\Classes\Defaults;
use Tests\Unit\Classes\FriendBehavior;
use Tests\Unit\Classes\Grandchild;
use Tests\Unit\Classes\IdentityBehavior;
use Tests\Unit\Classes\InheritsName;
use Tests\Unit\Classes\Noop;
use Tests\Unit\Classes\ParentConfig;
use Tests\Unit\Classes\ParentOfKeyedChildren;
use Tests\Unit\Classes\ParentOfManyChildren;
use Tests\Unit\Classes\ParentOfSingleChild;
use Tests\Unit\Classes\Permissions;
use Tests\Unit\Classes\SetThingBehavior;
use Tests\Unit\Traits\DynamicTrait;

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
            use DynamicTrait;

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

            public function getDefaultDynamicConfig()
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

    public function test_parent_of_only_child()
    {
        $parent = ParentOfManyChildren::create([
            'children' => [
                'child' => ['name' => 'bob'],
                'name' => 'alice',
            ],
        ]);
        
        $this->assertEquals([
            'children' => [
                [
                    'child' => ['name' => 'bob'],
                    'name' => 'alice',
                ],
            ],
        ], $parent->toArray());
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
                ['name' => 'alice', 'age' => 35, 'order' => 2],
                ['name' => 'bob', 'age' => 40, 'order' => 1],
                ['name' => 'cindy', 'age' => 45, 'order' => 0],
            ],
        ]);
        
        $this->assertEquals('cindy', $parent->keyed_children[0]->name);
        $this->assertEquals(45, $parent->keyed_children[0]->age);

        $this->assertEquals('bob', $parent->keyed_children[1]->name);
        $this->assertEquals(40, $parent->keyed_children[1]->age);
        
        $this->assertEquals('alice', $parent->keyed_children[2]->name);
        $this->assertEquals(35, $parent->keyed_children[2]->age);
    }

    public function test_inheriting_config_from_parent()
    {
        $config = new class extends Config
        {
            public function defineChildren(): array
            {
                return [
                    'child' => InheritsName::class,
                    'children' => [InheritsName::class],
                    'keyed_children' => [InheritsName::class, 'id'],
                ];
            }

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

    public function test_descending_child_tree()
    {
        $parent = ParentConfig::create([
            'child' => [
                'children' => [
                    ['id' => 'baz'],
                    ['id' => 'qux'],
                ],
                'id' => 'bar',
            ],
            'id' => 'foo', // <- not a descendent, should be excluded
        ]);

        $descendents = [];
        
        $parent->descendents(function ($child) use (&$descendents) {
            $descendents[] = $child->id;
        });
        
        $this->assertEquals(['bar', 'baz', 'qux'], $descendents);
    }

    public function test_invalid_config_throws_exception_with_path()
    {
        $config = new class extends Config
        {
            public function getValidationRules(): array
            {
                return [
                    'name' => ['required', 'string'],
                ];
            }
        };

        $this->expectException(ConfigurationException::class);
        
        $config->validate();
    }

    public function test_invalid_descendent_config_throws_exception()
    {
        $parent = ParentConfig::create([
            'child' => [
                'child' => ['invalid' => true],
            ],
        ]);

        $this->expectException(ConfigurationException::class);
        
        $parent->validate();
    }

    public function test_merging_dynamic_validation_rules()
    {
        $config = new class extends Config
        {
            public function getValidationRules(): array
            {
                return [
                    'name' => ['string'],
                    'foo' => ['required'],
                ];
            }

            public function getDynamicValidationRules(): array
            {
                $rules = $this->getValidationRules();

                return [
                    'name' => array_merge($rules['name'], ['required']), // <- make an existing rule required
                    'age' => ['integer'], // <- add a new rule
                    'foo' => null, // <- overwrite foo with null to remove the required rule
                ];
            }
        };

        $this->assertEquals([
            'name' => ['string', 'required'],
            'age' => ['integer'],
        ], $config->__rules);
    }

    public function test_normalizing_keyed_child_config()
    {
        $config = ParentConfig::create([
            'keyed_children' => [
                'foo' => [],
                'bar' => [],
            ],
        ]);
        
        $this->assertEquals([
            'keyed_children' => [
                ['id' => 'foo'],
                ['id' => 'bar'],
            ],
        ], $config->__config);
    }

    public function test_computed_property()
    {
        $config = new class extends Config
        {
            public function getDefaultConfig(): array
            {
                return [
                    'name' => 'alice',
                ];
            }

            public function getUppercaseNameAttribute(): string
            {
                return strtoupper($this->name);
            }
        };

        $this->assertEquals($config->uppercaseName, 'ALICE');

        $this->assertEquals($config->uppercase_name, 'ALICE');
    }


    public function test_config_path_for_direct_child()
    {
        $config = new class extends Config
        {
            public function getDefaultConfig(): array
            {
                return [
                    'thing' => [],
                ];
            }

            public function defineChildren(): array
            {
                return [
                    'thing' => Config::class,
                ];
            }
        };

        $this->assertEquals('thing', $config->thing->getFullConfigPath());
    }

    public function test_config_path_for_indexed_children()
    {
        $config = new class extends Config
        {
            public function getDefaultConfig(): array
            {
                return [
                    'things' => [
                        ['id' => 'foo'],
                    ],
                ];
            }

            public function defineChildren(): array
            {
                return [
                    'things' => [Config::class],
                ];
            }
        };

        $this->assertEquals('things.0', $config->things[0]->getFullConfigPath());
    }

    public function test_config_path_for_keyed_children()
    {
        $config = new class extends Config
        {
            public function getDefaultConfig(): array
            {
                return [
                    'things' => [
                        'foo' => ['id' => 'foo'],
                    ],
                ];
            }

            public function defineChildren(): array
            {
                return [
                    'things' => [Config::class, 'id'],
                ];
            }
        };

        $this->assertEquals('things.foo', $config->things[0]->getFullConfigPath());
    }

    public function test_config_path_for_only_child()
    {
        $config = new class extends Config
        {
            public function getDefaultConfig(): array
            {
                return [
                    'things' => [
                        'id' => 'foo',
                    ],
                ];
            }

            public function defineChildren(): array
            {
                return [
                    'things' => [Config::class],
                ];
            }
        };

        $this->assertEquals('things', $config->things[0]->getFullConfigPath());
    }

    public function test_accessing_data_via_behavior()
    {
        $config = new class extends Config
        {
            public function defineBehaviors(): array
            {
                return [
                    CatchphraseBehavior::class,
                ];
            }
        };

        $this->assertEquals('Wubba-lubba-dub-dub!', $config->catchphrase);
    }

    public function test_mutating_state_from_a_behavior()
    {
        $config = new class extends Config
        {
            public function defineBehaviors(): array
            {
                return [
                    FriendBehavior::class,
                ];
            }
        };
        
        $config->befriend('Bird person');

        $this->assertEquals('Bird person', $config->friend);
    }

    public function test_setting_default_config_via_attribute()
    {
        $empty = new class extends Config
        {
            public function defineBehaviors(): array
            {
                return [
                    DefaultConfigBehavior::class,
                ];
            }
        };

        $filled = new class extends Config
        {
            public function defineBehaviors(): array
            {
                return [
                    DefaultConfigBehavior::class,
                ];
            }

            public function getDefaultThingConfig()
            {
                return 'new value';
            }
        };

        $this->assertEquals('thing', $empty->thing);

        $this->assertEquals('new value', $filled->thing);
    }

    public function test_setting_data_via_attribute()
    {
        $config = new class extends Config
        {
            public function defineBehaviors(): array
            {
                return [
                    SetThingBehavior::class,
                ];
            }

            public function getDefaultConfig(): array
            {
                return [
                    'thing' => 'hello world',
                ];
            }
        };
        
        $this->assertEquals('HELLO WORLD', $config->thing);
    }

    public function test_calling_method_on_behavior()
    {
        $config = new class extends Config
        {
            public function defineBehaviors(): array
            {
                return [
                    IdentityBehavior::class,
                ];
            }
        };

        $n = mt_rand() / mt_getrandmax();
        
        $this->assertEquals($n, $config->identity($n));
    }

    public function test_calling_overwritten_behavior_method()
    {
        $config = new class extends Config
        {
            public function defineBehaviors(): array
            {
                return [
                    IdentityBehavior::class,
                ];
            }

            public function identity()
            {
                return 'oops';
            }
        };

        $n = mt_rand() / mt_getrandmax();
        
        $this->assertEquals('oops', $config->identity($n));
    }
}
