<?php

namespace Tests\Feature;

use Bedard\Backend\Configuration\Configuration;
use Bedard\Backend\Exceptions\ConfigurationException;
use Illuminate\Support\Collection;
use Tests\Feature\Classes\AttributeSetter;
use Tests\Feature\Classes\BaseRules;
use Tests\Feature\Classes\BlankConfig;
use Tests\Feature\Classes\ChildConfig;
use Tests\Feature\Classes\ExtensionRules;
use Tests\Feature\Classes\GrandchildConfig;
use Tests\Feature\Classes\InheritConfig;
use Tests\Feature\Classes\LazyChild;
use Tests\Feature\Classes\LazyParent;
use Tests\Feature\Classes\OverwriteRules;
use Tests\Feature\Classes\ParentConfig;
use Tests\Feature\Classes\TestConfig;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
    public function test_invalid_config_throws_exception()
    {
        $this->expectException(ConfigurationException::class);

        $config = new class extends Configuration {
            public function defineValidation(): array
            {
                return ['id' => 'required'];
            }
        };
    }

    public function test_default_values_and_prop_normalizing()
    {
        $config = TestConfig::create([
            'child' => ['name' => 'one'],
            'children' => [
                ['name' => 'two'],
                ['name' => 'three'],
            ],
            'keyed_children' => [
                'foo' => ['name' => 'four'],
                'bar' => ['name' => 'five'],
            ],
        ]);

        $this->assertEquals([
            'child' => ['name' => 'one'],
            'children' => [
                ['name' => 'two'],
                ['name' => 'three'],
            ],
            'keyed_children' => [
                ['id' => 'foo', 'name' => 'four'],
                ['id' => 'bar', 'name' => 'five'],
            ],
            'other_child' => null,
            'other_children' => [],
            'other_keyed_children' => [],
            'array' => [],
            'bool' => true,
            'int' => 1,
            'null' => null,
            'string' => 'string',
        ], $config->config);
    }

    public function test_instantiating_props_and_data()
    {
        $config = TestConfig::create([
            'string' => 'hello',
            'child' => ['name' => 'one'],
            'children' => [
                ['name' => 'two'],
                ['name' => 'three'],
            ],
            'keyed_children' => [
                'foo' => ['name' => 'four'],
                'bar' => ['name' => 'five'],
            ],
        ]);

        $this->assertInstanceOf(Collection::class, $config->get('children'));
        $this->assertInstanceOf(Collection::class, $config->get('keyed_children'));
        $this->assertInstanceOf(Collection::class, $config->get('other_children'));
        $this->assertInstanceOf(Collection::class, $config->get('other_keyed_children'));

        $this->assertInstanceOf(BlankConfig::class, $config->get('child'));
        $this->assertInstanceOf(BlankConfig::class, $config->get('children.0'));
        $this->assertInstanceOf(BlankConfig::class, $config->get('children.1'));
        $this->assertInstanceOf(BlankConfig::class, $config->get('keyed_children.0'));
        $this->assertInstanceOf(BlankConfig::class, $config->get('keyed_children.1'));
        
        $this->assertEquals('hello', $config->get('string'));
        $this->assertEquals('one', $config->get('child.name'));
        $this->assertEquals('two', $config->get('children.0.name'));
        $this->assertEquals('three', $config->get('children.1.name'));
        $this->assertEquals('foo', $config->get('keyed_children.0.id'));
        $this->assertEquals('four', $config->get('keyed_children.0.name'));
        $this->assertEquals('bar', $config->get('keyed_children.1.id'));
        $this->assertEquals('five', $config->get('keyed_children.1.name'));
    }

    public function test_single_item_from_assoc_array()
    {
        $config = TestConfig::create([
            'children' => [
                'name' => 'foo',
            ],
        ]);
        
        $this->assertEquals(1, $config->get('children')->count());
        $this->assertInstanceOf(BlankConfig::class, $config->get('children.0'));
        $this->assertEquals('foo', $config->get('children.0.name'));
    }

    public function test_ancestor_access()
    {
        $parent = ParentConfig::create([
            'child' => [
                'grandchild' => [
                    'name' => 'hello',
                ],
            ],
        ]);

        $child = $parent->get('child');
        
        $grandchild = $parent->get('child.grandchild');

        $this->assertInstanceOf(ChildConfig::class, $child);
        $this->assertInstanceOf(GrandchildConfig::class, $grandchild);

        $this->assertEquals($parent, $parent->root());
        $this->assertEquals($parent, $child->root());
        $this->assertEquals($parent, $grandchild->root());

        $this->assertEquals(null, $parent->closest(ParentConfig::class));
        $this->assertEquals($parent, $child->closest(ParentConfig::class));
        $this->assertEquals($parent, $grandchild->closest(ParentConfig::class));
    }

    public function test_inheriting_parent_config()
    {
        $parent = ParentConfig::create([
            'child' => [
                'grandchild' => [],
            ],
        ]);

        $this->assertNull($parent->get('child.name'));
        
        $this->assertEquals('foo', $parent->get('child.grandchild.name'));
    }

    public function test_overwriting_inherited_config()
    {
        $parent = ParentConfig::create([
            'child' => [
                'grandchild' => [
                    'name' => 'bar',
                ],
            ],
        ]);

        $this->assertNull($parent->get('child.name'));
        
        $this->assertEquals('bar', $parent->get('child.grandchild.name'));
    }

    public function test_casting_configuration_to_array()
    {
        $config = TestConfig::create([
            'child' => ['name' => 'one'],
            'children' => [
                ['name' => 'two'],
                ['name' => 'three'],
            ],
            'keyed_children' => [
                'foo' => ['name' => 'four'],
                'bar' => ['name' => 'five'],
            ],
        ]);
        
        $this->assertEquals([
            'child' => ['name' => 'one'],
            'children' => [
                ['name' => 'two'],
                ['name' => 'three'],
            ],
            'keyed_children' => [
                ['id' => 'foo', 'name' => 'four'],
                ['id' => 'bar', 'name' => 'five'],
            ],
            'array' => [],
            'bool' => true,
            'int' => 1,
            'null' => null,
            'string' => 'string',
            'other_child' => null,
            'other_children' => [],
            'other_keyed_children' => [],
        ], $config->toArray());
    }

    public function test_non_instantiation_of_keyed_array()
    {
        $config = LazyParent::create([
            'child' => ['name' => 'one'],
            'children' => [
                ['name' => 'two'],
                ['name' => 'three'],
            ],
            'keyed_children' => [
                'foo' => ['name' => 'four'],
                'bar' => ['name' => 'five'],
            ],
        ]);
        
        $this->assertIsArray($config->get('child'));
        $this->assertInstanceOf(Collection::class, $config->get('children'));
        $this->assertInstanceOf(Collection::class, $config->get('keyed_children'));

        $this->assertEquals(['name' => 'one'], $config->get('child'));

        $this->assertEquals([
            ['name' => 'two'],
            ['name' => 'three'],
        ], $config->get('children')->toArray());

        $this->assertEquals([
            ['id' => 'foo', 'name' => 'four'],
            ['id' => 'bar', 'name' => 'five'],
        ], $config->get('keyed_children')->toArray());
    }

    public function test_child_nodes_set_parent_key()
    {
        $config = ParentConfig::create([
            'child' => ['name' => 'one'],
            'children' => [
                ['name' => 'two'],
            ],
            'keyed_children' => [
                'foo' => ['name' => 'four'],
            ],
        ]);

        $this->assertEquals('child', $config->get('child')->parentKey);

        $this->assertEquals('children', $config->get('children.0')->parentKey);

        $this->assertEquals('keyed_children.foo', $config->get('keyed_children.0')->parentKey);   
    }

    public function test_extending_validation_rules()
    {
        $config = ExtensionRules::create(['foo' => 'bar']);

        $this->assertEquals([
            'foo' => ['string', 'nullable'],
            'bar' => ['string'],
        ], $config->defineValidation());
    }

    public function test_overwriting_validation_rules()
    {
        $config = OverwriteRules::create(['foo' => 1]);

        $this->assertEquals([
            'foo' => ['integer'],
        ], $config->defineValidation());
    }

    public function test_configuration_attribute_setter()
    {
        $config = AttributeSetter::create(['test' => 'foo-bar-baz']);

        $this->assertEquals('FOO-BAR-BAZ', $config->get('test'));
    }
}
