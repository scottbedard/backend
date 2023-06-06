<?php

namespace Tests\Feature;

use Bedard\Backend\Config\Config;
use Tests\Feature\Classes\RestrictedThing;
use Tests\TestCase;

class ConfigPermissionsTest extends TestCase
{
    public function test_super_admin_has_access_to_everything()
    {
        $alice = $this->loginAsSuperAdmin();

        $config = new class extends Config
        {
            public function defineChildren(): array
            {
                return [
                    'thing' => RestrictedThing::class,
                ];
            }

            public function getDefaultConfig(): array
            {
                return [
                    'thing' => [
                        'permissions' => ['access']
                    ],
                ];
            }
        };
        
        $this->assertInstanceOf(RestrictedThing::class, $config->thing);
    }

    public function test_user_can_only_access_with_permissions()
    {
        $bob = $this->loginAsUserThatCan('do stuff');
        
        $restricted = new class extends Config
        {
            public function defineChildren(): array
            {
                return [
                    'thing' => RestrictedThing::class,
                ];
            }

            public function getDefaultConfig(): array
            {
                return [
                    'thing' => [
                        'permissions' => ['access']
                    ],
                ];
            }
        };

        $allowed = new class extends Config
        {
            public function defineChildren(): array
            {
                return [
                    'thing' => RestrictedThing::class,
                ];
            }

            public function getDefaultConfig(): array
            {
                return [
                    'thing' => [
                        'permissions' => ['do stuff']
                    ],
                ];
            }
        };
        
        $this->assertNull($restricted->thing);
        $this->assertInstanceOf(RestrictedThing::class, $allowed->thing);
    }
}
