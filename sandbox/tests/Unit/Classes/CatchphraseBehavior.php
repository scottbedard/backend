<?php

namespace Tests\Unit\Classes;

use Bedard\Backend\Config\Behaviors\Behavior;

class CatchphraseBehavior extends Behavior
{
    public function getCatchphraseAttribute()
    {
        return 'Wubba-lubba-dub-dub!';
    }
}
