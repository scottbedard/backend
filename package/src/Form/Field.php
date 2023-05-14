<?php

namespace Bedard\Backend\Form;

use Bedard\Backend\Classes\Breakpoint;
use Bedard\Backend\Configuration\Configuration;
use Illuminate\View\View;

class Field extends Configuration
{
    /**
     * Auto-create child instances
     *
     * @var bool
     */
    public static bool $autocreate = false;

    /**
     * Default data
     *
     * @var array
     */
    public array $defaults = [
        'order' => 0,
        'span' => 12,
        'type' => null,
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public array $rules = [
        'id' => 'required',
        'label' => ['present', 'nullable', 'string'],
        'order' => ['present', 'integer'],
        'type' => ['present', 'nullable', 'string'],
    ];

    /**
     * Construct
     *
     * @param array $config
     * @param ?\Bedard\Backend\Configuration\Configuration $parent
     */
    public function __construct(array $config = [], ?Configuration $parent = null)
    {
        data_fill($config, 'label', str(data_get($config, 'id'))->headline()->toString());

        data_set($config, 'span', Breakpoint::create(data_get($config, 'span', 12)));

        parent::__construct($config, $parent);
    }

    /**
     * Render
     *
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('backend::form.input', [
            'field' => $this,
        ]);
    }
}
