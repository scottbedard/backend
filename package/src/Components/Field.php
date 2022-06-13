<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Components\Group;

class Field extends Group
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'context' => null,
        'id' => '',
        'label' => '',
        'value' => null,
    ];
    
    /**
     * Subclass constructor aliases
     *
     * @var array
     */
    public static $subclasses = [
        'date' => \Bedard\Backend\Components\DateField::class,
        'input' => \Bedard\Backend\Components\InputField::class,
    ];

    /**
     * Init
     *
     * @param string $key
     *
     * @return void
     */
    public function init(string $id = '')
    {
        $this->attributes['id'] = $id;
        $this->attributes['label'] = $id;
    }
}
