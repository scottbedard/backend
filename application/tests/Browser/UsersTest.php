<?php

namespace Tests\Browser;

use App\Models\User;
use Backend;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_creating_a_user()
    {
        $user = User::factory()->create();

        Backend::authorize($user, 'super admin');

        $this->browse(function (Browser $browser) use ($user) {
            $email = 'john@example.com';

            $this->assertFalse(User::where('email', $email)->exists());

            $browser
                ->loginAs($user)
                ->visitRoute('backend.resources.show', ['id' => 'users'])
                ->click('a[href="' . route('backend.resources.create', ['id' => 'users']) . '"]')
                ->assertRouteIs('backend.resources.create', ['id' => 'users'])
                ->value('input[name="form[name]"]', 'John')
                ->value('input[name="form[email]"]', $email)
                ->value('input[name="form[password]"]', 'secret')
                ->value('input[name="form[confirm_password]"]', 'secret')
                ->press('button[type="submit"]')
                ->assertRouteIs('backend.resources.show', ['id' => 'users']);

            $john = User::where('email', $email)->firstOrFail();

            $this->assertEquals('John', $john->name);

            $this->assertTrue(Hash::check('secret', $john->password));
        });
    }

    public function test_deleting_a_user()
    {
        $admin = User::factory()->create();
        $otherUser = User::factory()->create();

        Backend::authorize($admin, 'super admin');

        $this->browse(function (Browser $browser) use ($admin, $otherUser) {
            $browser
                ->loginAs($admin)
                ->visitRoute('backend.resources.edit', ['id' => 'users', 'modelId' => $otherUser->id])
                ->press('Delete user')
                ->press('Confirm delete')
                ->assertRouteIs('backend.resources.show', ['id' => 'users']);
            
            $this->assertFalse(User::where('id', $otherUser->id)->exists());
        });
    }

    // @todo: test deleting multiple users

    // @todo: test updating users

    // @todo: test pagination

    // @todo: test sorting

    // @todo: test filtering
}
