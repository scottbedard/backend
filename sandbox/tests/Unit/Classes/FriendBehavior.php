<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Behavior;

class FriendBehavior extends Behavior
{
    public function befriend(string $name)
    {
        data_set($this->config->__data, 'friend', $name);
    }
}
