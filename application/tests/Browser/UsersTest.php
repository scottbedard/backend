<?php

namespace Tests\Browser;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\Table;
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

    public function test_deleting_single_user()
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

    public function test_deleting_multiple_users()
    {
        $this->browse(function (Browser $browser) {
            $admin = $this->superAdmin();
            $joe = User::factory()->create();
            $mary = User::factory()->create();

            $browser
                ->loginAs($admin)
                ->visitRoute('backend.resources.show', ['id' => 'users'])
                ->within(new Table, function ($table) {
                    $table
                        ->toggleRowCheckbox(1)
                        ->toggleRowCheckbox(2);
                })
                ->press('Delete')
                ->press('Confirm');

            $this->assertFalse(User::where('id', $joe->id)->exists());
            $this->assertFalse(User::where('id', $mary->id)->exists());
        });
    }

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
                ->within(new Table, fn ($table) => $table->assertNoRowsSelected())
                
                // clicking header checkbox selects all body checkboxes
                // and enables delete button
                ->within(new Table, function ($table) {
                    $table
                        ->toggleHeaderCheckbox()
                        ->assertAllRowsSelected();
                })
                ->assertEnabled('#delete button')
                
                // clicking header again deselects body checkboxes
                ->within(new Table, function ($table) {
                    $table
                        ->toggleHeaderCheckbox()
                        ->assertNoRowsSelected();
                })
                ->assertButtonDisabled('#delete button')
                
                // selecting one row does not select header
                ->with(new Table, function ($table) {
                    $table
                        ->toggleRowCheckbox(0)
                        ->assertHeaderNotSelected();
                })
                ->assertButtonEnabled('#delete button')

                // selecting the final row selects the header
                ->within(new Table, function ($table) {
                    $table
                        ->toggleRowCheckbox(1)
                        ->assertHeaderSelected();
                })
                ->assertButtonEnabled('#delete button')
                
                // deselecting the final row deselects the header
                ->within(new Table, function ($table) {
                    $table
                        ->toggleRowCheckbox(1)
                        ->assertHeaderNotSelected();
                })
                ->assertButtonEnabled('#delete button')
                
                // deselecting the first row disables the button
                ->within(new Table, function ($table) {
                    $table->toggleRowCheckbox(0);
                })
                ->assertButtonDisabled('#delete button');
        });
    }

    public function test_updating_a_user()
    {
        $this->browse(function (Browser $browser) {
            $admin = $this->superAdmin();

            $joe = User::factory()->create();

            $browser
                ->loginAs($admin)
                ->visitRoute('backend.resources.show', ['id' => 'users'])
                ->within(new Table, fn ($table) => $table->clickRow(1))
                ->assertRouteIs('backend.resources.edit', ['id' => 'users', 'modelId' => $joe->id])
                ->value('[name="form[name]"', 'Hello world')
                ->value('[name="form[email]"', 'foo@bar.com')
                ->press('Save')
                ->assertRouteIs('backend.resources.show', ['id' => 'users']);
            
            $joe->refresh();

            $this->assertEquals('Hello world', $joe->name);

            $this->assertEquals('foo@bar.com', $joe->email);
        });
    }

    public function test_interacting_with_date_field()
    {
        $this->browse(function (Browser $browser) {
            $admin = $this->superAdmin();

            $currentDate = Carbon::now()->format('j');

            $targetDate = $currentDate === '1'
                ? Carbon::now()->addDay()->format('j')
                : Carbon::now()->subDay()->format('j');

            $lastMonth = Carbon::now()->subMonth()->format('F');

            $currentMonth = Carbon::now()->format('F');

            $nextMonth = Carbon::now()->addMonth()->format('F');

            $value = $currentDate === '1'
                ? Carbon::now()->addDay()->startOfDay()->toDateTimeString()
                : Carbon::now()->subDay()->startOfDay()->toDateTimeString();

            $browser
                ->loginAs($admin)
                ->visitRoute('backend.resources.edit', ['id' => 'users', 'modelId' => $admin->id])

                // clicking the field should expand the calendar
                ->assertNotPresent(('[data-calendar]'))
                ->click('[data-date-field="created_at"]')
                ->assertPresent(('[data-calendar]'))

                // go to last month
                ->click('[data-prev]')
                ->assertSeeIn('[data-month]', $lastMonth)

                // go to current month
                ->click('[data-next]')
                ->assertSeeIn('[data-month]', $currentMonth)
                
                // go to next month
                ->click('[data-next]')
                ->assertSeeIn('[data-month]', $nextMonth)
                
                // return to current month and click date
                ->click('[data-prev]')
                ->click('[data-date="' . $targetDate .'"]')
                ->assertValue('[name="form[created_at]"]', $value);
        });
    }

    public function test_icon_column()
    {
        $this->browse(function (Browser $browser) {
            $admin = $this->superAdmin();

            User::factory()->create(['email_verified_at' => null]);

            $browser
                ->loginAs($admin)
                ->visitRoute('backend.resources.show', ['id' => 'users'])
                ->assertPresent('[data-table-row="0"] [data-icon-column="check"][data-icon-column-success]')
                ->assertPresent('[data-table-row="1"] [data-icon-column="x"][data-icon-column-danger]');
            ;
        });
    }

    public function test_sorting_users_by_name()
    {
        $this->browse(function (Browser $browser) {
            $admin = $this->superAdmin(['name' => 'alex']);
            User::factory()->create(['name' => 'bob']);
            User::factory()->create(['name' => 'cindy']);

            $browser
                ->loginAs($admin)
                ->visitRoute('backend.resources.show', ['id' => 'users'])
                ->within(new Table, function ($table) {
                    // default order is defined on the table instance
                    $table->assertOrder('id', 'asc')

                        // clicking a header sorts by that column
                        ->clickHeader('name')
                        ->assertOrder('name', 'asc')
                        ->assertSeeInCell('name', 0, 'alex')
                        ->assertSeeInCell('name', 1, 'bob')
                        ->assertSeeInCell('name', 2, 'cindy')

                        // clicking an ascending header switches to descending
                        ->clickHeader('name')
                        ->assertOrder('name', 'desc')
                        ->assertSeeInCell('name', 0, 'cindy')
                        ->assertSeeInCell('name', 1, 'bob')
                        ->assertSeeInCell('name', 2, 'alex')
                        
                        // clicking a descending header switches to ascending
                        ->clickHeader('name')
                        ->assertOrder('name', 'asc');
                })
            ;
        });
    }

    // @todo: test pagination

    // @todo: test filtering
}
