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
        $admin = $this->superAdmin();

        $this->browse(function (Browser $browser) use ($admin) {
            $email = 'john@example.com';

            $this->assertFalse(User::where('email', $email)->exists());

            $browser
                ->loginAs($admin)
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
        $admin = $this->superAdmin();
        
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($admin, $user) {
            $browser
                ->loginAs($admin)
                ->visitRoute('backend.resources.edit', ['id' => 'users', 'modelId' => $user->id])
                ->press('Delete user')
                ->press('Confirm delete')
                ->assertRouteIs('backend.resources.show', ['id' => 'users']);
            
            $this->assertFalse(User::where('id', $user->id)->exists());
        });
    }

    // @todo: test deleting multiple users

    // @todo: test updating users

    // @todo: test pagination

    // @todo: test sorting

    // @todo: test filtering
}
