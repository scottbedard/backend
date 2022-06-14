<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    // use DatabaseMigrations;
    
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        // $user = User::factory()->create();

        $this->browse(function (Browser $browser) {
            $browser
                // ->loginAs($user)
                ->visit('/')
                ->assertSee('Laravel');
                // ->assertAuthenticated();
        });
    }
}
