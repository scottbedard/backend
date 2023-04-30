<?php

namespace Tests\Feature\Classes;

use Bedard\Backend\Configuration\Configuration;

class DefaultValuesConfig extends Configuration
{
    public array $defaults = [
        'blank' => null,
        'foo' => 'bar',
        'hello' => 'world',
        'things' => [],
    ];
}
