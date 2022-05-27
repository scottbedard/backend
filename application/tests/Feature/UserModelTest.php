<?php

namespace Tests\Feature;

use App\Models\User;
use Backend;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    public function test_user_has_many_backend_permissions()
    {
        $user = User::factory()->create();
        
        Backend::authorize($user, 'foo', 'bar');
        Backend::authorize($user, 'baz', 'qux');

        $this->assertEquals(2, $user->backendPermissions()->count());
    }
}
