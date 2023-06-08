<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Behaviors\Behavior;
use Bedard\Backend\Config\Config;
use Bedard\Backend\Exceptions\RejectConfigException;

class RejectBehavior extends Behavior
{
    public function __construct(Config $config, array $raw)
    {
        if (array_key_exists('reject', $raw) && $raw['reject'] === true) {
            $this->reject();
        }
    }
}
