<?php

namespace Tests\Unit;

use Bedard\Backend\Config\Config;
use Tests\TestCase;
use Tests\Unit\Classes\Permissions;

class ConfigPermissionsTest extends TestCase
{
    public function test_child_config_appends_to_inherited_parent_config()
    {
        $config = new class extends Permissions
        {
            public function defineChildren(): array
            {
                return [
                    'thing' => Permissions::class,
                    'things' => [Permissions::class],
                    'keyed_things' => [Permissions::class, 'id'],
                ];
            }

            public function defineDefaults(): array
            {
                return [
                    'permissions' => ['access'],
                    'thing' => ['permissions' => ['read']],
                    'things' => [
                        ['permissions' => ['update']],
                    ],
                    'keyed_things' => [
                        'foo' => ['permissions' => ['delete']],
                    ],
                ];
            }
        };

        $this->assertEquals(['access'], $config->permissions);
        $this->assertEquals(['access', 'read'], $config->thing->permissions);
        $this->assertEquals(['access', 'update'], $config->things[0]->permissions);
        $this->assertEquals(['access', 'delete'], $config->keyed_things[0]->permissions);
    }

    public function test_super_admin_has_access_to_everything()
    {
        $alice = $this->loginAsSuperAdmin();

        $config = new class extends Permissions
        {
            public function defineChildren(): array
            {
                return [
                    'thing' => Permissions::class,
                    'things' => [Permissions::class],
                    'keyed_things' => [Permissions::class, 'id'],
                ];
            }

            public function defineDefaults(): array
            {
                return [
                    'permissions' => ['access'],
                    'thing' => ['permissions' => ['read']],
                    'things' => [
                        ['permissions' => ['update']],
                    ],
                    'keyed_things' => [
                        'foo' => ['permissions' => ['delete']],
                    ],
                ];
            }
        };
    }
}
