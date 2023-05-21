<?php

namespace Bedard\Backend\Form;

use Bedard\Backend\Classes\Breakpoint;
use Bedard\Backend\Configuration\Configuration;
use Bedard\Backend\Exceptions\ConfigurationException;
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
    public static array $defaults = [
        'order' => 0,
        'span' => 12,
        'type' => InputField::class,
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static array $rules = [
        'id' => 'required',
        'label' => ['present', 'nullable', 'string'],
        'order' => ['present', 'integer'],
        'span' => ['present'],
        'type' => ['required', 'string'],
    ];

    /**
     * Construct
     *
     * @param array $config
     * @param ?\Bedard\Backend\Configuration\Configuration $parent
     * @param ?string $parentKey
     */
    public function __construct(array $config = [], ?Configuration $parent = null, ?string $parentKey = null)
    {
        data_fill($config, 'label', str(data_get($config, 'id'))->headline()->toString());

        data_set($config, 'span', Breakpoint::create(data_get($config, 'span', 12)));

        parent::__construct($config, $parent, $parentKey);
    }

    /**
     * Create a field from it's type
     *
     * @param array $config
     * @param ?\Bedard\Backend\Configuration\Configuration $parent
     * @param ?string $parentKey
     * 
     * @return self
     */
    public static function createFromType(array $config = [], ?Configuration $parent = null, ?string $parentKey = null): self
    {
        if (!array_key_exists('type', $config)) {
            throw new ConfigurationException('Missing field type');
        }

        $type = $config['type'];

        if (class_exists($type)) {
            return new $type($config, $parent, $parentKey);
        }

        $fields = config('backend.fields');

        if (array_key_exists($type, $fields)) {
            return new $fields[$type]($config, $parent, $parentKey);
        }

        throw new ConfigurationException("Unknown field type \"{$type}\"");
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
