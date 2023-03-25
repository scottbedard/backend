<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BackendMiddlewareTest extends TestCase
{
    public function test_guests_are_redirected(): void
    {
        $this
            ->get(config('backend.path'))
            ->assertRedirect(config('backend.guest_redirect'));
    }
}
