<?php

namespace Tests\Feature;

use App\Models\User;
use Bedard\Backend\Console\PermissionCommand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BackendControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_the_backend()
    {
        $this
            ->get(config('backend.path'))
            ->assertRedirect(config('backend.guest_redirect'));
    }
}
