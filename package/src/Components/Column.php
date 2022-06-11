<?php

namespace Bedard\Backend\Components;

use Bedard\Backend\Components\Component;

class Column extends Component
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'align' => 'left',
        'header' => '',
        'id' => '',
    ];

    /**
     * Initialize
     *
     * @param string $id
     *
     * @return void
     */
    public function init($id = '')
    {
        $this->attributes['id'] = $id;
    }

    /**
     * Render
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return 'hello';
    }
}
