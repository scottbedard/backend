<?php

namespace Tests\Feature\Backend;

use App\Backend\Resources\UserResource;
use Backend;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_resources()
    {
        $resources = Backend::resources();

        $this->assertTrue($resources->contains(UserResource::class));
    }

    public function test_get_resource_by_id()
    {
        $this->assertInstanceOf(UserResource::class, Backend::resource('users'));
    }
}
