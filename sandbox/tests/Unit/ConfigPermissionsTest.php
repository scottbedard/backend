<?php

namespace Tests\Unit;

use Bedard\Backend\Config\Config;
use Tests\Unit\Classes\Permissions;
use PHPUnit\Framework\TestCase;

class ConfigPermissionsTest extends TestCase
{
    public function test_child_config_appends_to_inherited_parent_config()
    {
        $config = new class extends Permissions
        {
            public function defineChildren(): array
            {
                return [
                    'child' => Permissions::class,
                    'children' => [Permissions::class],
                    'keyed_children' => [Permissions::class, 'id'],
                ];
            }

            public function getDefaultConfig(): array
            {
                return [
                    'permissions' => ['read'],
                    'child' => [
                        'permissions' => ['delete'],
                    ],
                ];
            }
        };

        $this->assertEquals(['read', 'delete'], $config->child->permissions);
    }
}
