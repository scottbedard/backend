<?php

namespace Tests\Feature;

use Bedard\Backend\Config\Config;
use Illuminate\Support\Collection;
use Tests\Feature\Classes\RestrictedThing;
use Tests\TestCase;

class ConfigPermissionsTest extends TestCase
{
    public function test_protecting_config_behind_permissions()
    {
        $bob = $this->loginAsUserThatCan('thing', 'other things', 'keyed things');

        $config = new class extends Config
        {
            public function defineChildren(): array
            {
                return [
                    'empty_array' => [RestrictedThing::class],
                    'keyed_things' => [RestrictedThing::class, 'id'],
                    'other_things' => [RestrictedThing::class],
                    'restricted_thing' => RestrictedThing::class,
                    'thing' => RestrictedThing::class,
                ];
            }

            public function getDefaultConfig(): array
            {
                return [
                    'thing' => [
                        'id' => 'foo',
                        'permissions' => ['thing'],
                    ],
                    'restricted_thing' => [
                        'permissions' => ['restricted'],
                    ],
                    'other_things' => [
                        [
                            'id' => 'bar',
                            'permissions' => ['other things'],
                        ],
                        [
                            'id' => 'baz',
                            'permissions' => ['restricted'],
                        ],
                    ],
                    'keyed_things' => [
                        'qux' => [
                            'permissions' => ['keyed things'],
                        ],
                        'lol' => [
                            'permissions' => ['restricted'],
                        ],
                    ],
                    'empty_array' => [
                        [
                            'id' => 'wow',
                            'permissions' => ['restricted'],
                        ],
                    ],
                ];
            }
        };

        $this->assertInstanceOf(RestrictedThing::class, $config->thing);

        $this->assertNull($config->restricted_thing);

        $this->assertInstanceOf(Collection::class, $config->other_things);
        $this->assertEquals(1, $config->other_things->count());
        $this->assertEquals('bar', $config->other_things[0]->id);

        $this->assertInstanceOf(Collection::class, $config->keyed_things);
        $this->assertEquals(1, $config->keyed_things->count());
        $this->assertEquals('qux', $config->keyed_things[0]->id);

        $this->assertInstanceOf(Collection::class, $config->empty_array);
        $this->assertEquals(0, $config->empty_array->count());
    }
}
