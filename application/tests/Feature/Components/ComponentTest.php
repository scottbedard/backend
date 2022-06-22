<?php

namespace Tests\Feature\Components;

use App\Models\User;
use Backend;
use Bedard\Backend\Components\Component;
use Bedard\Backend\Components\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ComponentTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_only_renders_authorized_components()
    {
        $user = User::factory()->create();

        Auth::login($user);

        Backend::authorize($user, 'foo');

        $component = Group::text('outer')->items([
            Group::items([
                Group::text('one'),

                Group::permission('two')->text('two')
            ]),
        
            Group::permission('foo')->text('foo'),

            Group::permission('bar')->text('bar'),
        ]);

        $output = (string) $component->html();

        $this->assertStringContainsString('outer', $output);
        $this->assertStringContainsString('foo', $output);
        $this->assertStringContainsString('one', $output);
        $this->assertStringNotContainsString('bar', $output);
        $this->assertStringNotContainsString('two', $output);
    }

    public function test_only_components_in_correct_context()
    {
        $user = User::factory()->create();

        Auth::login($user);

        Backend::authorize($user, 'super admin');

        $component = Group::items([
            Group::text('get'),

            Group::context('create')->text('create'),

            Group::context('update')->text('update'),
        ]);

        $component->provide(['context' => 'create']);

        $output = (string) $component->html();
        
        $this->assertStringContainsString('get', $output);
        $this->assertStringContainsString('create', $output);
        $this->assertStringNotContainsString('update', $output);
    }

    public function test_flattening_component_tree_to_array()
    {
        $grandchild = Group::make();

        $child1 = Group::items([
            $grandchild,
        ]);

        $child2 = Group::make();

        $parent = Group::items([
            $child1,
            $child2,
        ]);
        
        $tree = $parent->flatten();
        
        $this->assertEquals($parent, $tree[0]);
        $this->assertEquals($child1, $tree[1]);
        $this->assertEquals($grandchild, $tree[2]);
        $this->assertEquals($child2, $tree[3]);
    }


    public function test_providing_data_to_child_components()
    {
        $grandchild = Group::make();

        $child1 = Group::items([
            $grandchild,
        ]);

        $child2 = Group::make();

        $parent = Group::items([
            $child1,
            $child2,
        ]);

        $data = ['foo' => 'bar'];

        $parent->provide($data);

        $this->assertEquals($data, $parent->data);
        $this->assertEquals($data, $child1->data);
        $this->assertEquals($data, $child2->data);
        $this->assertEquals($data, $grandchild->data);
    }
}
