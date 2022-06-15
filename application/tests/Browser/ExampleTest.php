<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        dd(
            env('DB_CONNECTION'),
            env('DB_DATABASE'),
            env('DB_HOST'),
            env('DB_PORT'),
            env('DB_USER'),
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            env('SESSION_DRIVER'),
        );

        // $user = User::factory()->create();

        $this->browse(function (Browser $browser) {
            $browser
                // ->loginAs($user)
                ->visit('/')
                ->dump();
                // ->assertAuthenticated();
        });
    }
}
