<?php

namespace Tests\Browser;

use App\Models\User;
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
    public function test_table_checkboxes()
    {
        $this->browse(function (Browser $browser) {
            $mary = $this->superAdmin();

            User::factory()->create();

            $browser
                ->loginAs($mary)
                ->visitRoute('backend.resources.show', ['id' => 'users'])
                
                // delete button should start disabled
                // all checkboxes should start deselected
                ->assertPresent('[data-table-body] [data-not-checked]')
                ->assertNotPresent('[data-table-body] [data-checked]')
                ->assertButtonDisabled('#delete button')
                
                // clicking header checkbox selects all body checkboxes
                // and enables delete button
                ->click('[data-table-header] [data-checkbox]')
                ->storeSource('debug')
                ->assertPresent('[data-table-body] [data-checked]');
                // ->assertNotPresent('[data-table-body] [data-not-checked]')
                // ->assertEnabled('#delete button')
                
                // // clicking header again deselects body checkboxes
                // ->click('[data-table-header] [data-checkbox]')
                // ->assertNotPresent('[data-table-body] [data-checked]')
                // ->assertButtonDisabled('#delete button')
                
                // // selecting one row does not select header
                // ->click('[data-table-row="0"] [data-checkbox]')
                // ->assertNotPresent('data-table-header] [data-checked]')
                // ->assertButtonEnabled('#delete button')

                // // selecting the final row selects the header
                // ->click('[data-table-row="1"] [data-checkbox]')
                // ->assertPresent('[data-table-header] [data-checked]')
                // ->assertButtonEnabled('#delete button')
                
                // // deselecting the final row deselects the header
                // ->click('[data-table-row="1"] [data-checkbox]')
                // ->assertNotPresent('[data-table-header] [data-checked]')
                // ->assertButtonEnabled('#delete button')
                
                // // deselecting the first row disables the button;
                // ->click('[data-table-row="0"] [data-checkbox]')
                // ->assertButtonDisabled('#delete button');
        });
    }

    // @todo: test updating users

    // @todo: test pagination

    // @todo: test sorting

    // @todo: test filtering
}
