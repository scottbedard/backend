<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Behavior;
use Bedard\Backend\Config\Config;

class RejectBehavior extends Behavior
{
    public function __construct(Config $config, array $raw)
    {
        if (array_key_exists('reject', $raw) && $raw['reject'] === true) {
            $this->reject();
        }
    }
}
