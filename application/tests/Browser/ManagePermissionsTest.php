<?php

namespace Tests\Browser;

use App\Models\User;
use Backend;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ManagePermissionsTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_super_admins_have_link_to_manage_permissions()
    {
        $admin = $this->superAdmin();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visitRoute('backend.index')
                ->click('a[data-manage-permissions-link]')
                ->assertRouteIs('backend.manage.permissions');
        });
    }

    public function test_lesser_admins_do_not_see_manage_permissions_link()
    {
        $admin = User::factory()->create();

        Backend::authorize($admin, 'manage users');

        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visitRoute('backend.index')
                ->assertNotPresent('a[data-manage-permissions-link]');
        });
    }
}
