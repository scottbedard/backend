<?php

namespace Bedard\Backend\Configuration;

class Route extends Configuration
{
    public array $rules = [
        'path' => ['nullable', 'string'],
    ];
}
