<?php

namespace Tests\Feature\Classes;

use Bedard\Backend\Configuration\Configuration;

class AttributeSetter extends Configuration
{
    public function setTestAttribute(string $value)
    {
        return str($value)->upper()->toString();
    }
}
