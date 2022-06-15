<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthenticationTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function test_logging_with_super_admin()
    {

        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('secret'),
        ]);

        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/')
                ->type('email', 'admin@example.com')
                ->type('password', 'secret')
                ->press('Log in')
                ->assertAuthenticated();
        });
    }
}
