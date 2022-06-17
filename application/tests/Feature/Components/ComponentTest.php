<?php

namespace Tests\Feature\Components;

use App\Models\User;
use Backend;
use Bedard\Backend\Components\Component;
use Bedard\Backend\Components\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ExampleTest extends TestCase
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
}
