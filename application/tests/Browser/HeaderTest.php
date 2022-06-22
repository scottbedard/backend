<?php

namespace Tests\Browser;

use App\Models\User;
use Backend;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HeaderTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_super_admins_see_admins_link()
    {
        $admin = $this->superAdmin();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visitRoute('backend.index')
                ->click('a[data-admins-link]')
                ->assertRouteIs('backend.admin.index');
        });
    }

    public function test_lesser_admins_do_not_see_admins_link()
    {
        $admin = User::factory()->create();

        Backend::authorize($admin, 'manage users');

        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visitRoute('backend.index')
                ->assertNotPresent('a[data-admins-link]');
        });
    }
}
