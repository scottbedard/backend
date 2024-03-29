<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BackendControllerTest extends TestCase
{
    // use RefreshDatabase;

    public function test_guests_are_redirected()
    {
        $this
            ->get(config('backend.path'))
            ->assertStatus(403);
    }
}
