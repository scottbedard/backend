<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BackendControllerTest extends TestCase
{
    // use RefreshDatabase;

    public function test_guests_are_redirected()
    {
        $this
            ->get(config('backend.path'))
            ->assertRedirect(config('backend.guest_redirect'));
    }
}
