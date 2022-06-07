<?php

namespace Bedard\Backend;

use Bedard\Backend\Classes\Fluent;
use Bedard\Backend\Exceptions\InvalidColumnAlignmentException;
use Bedard\Backend\Traits\InheritParentAttrs;
use Bedard\Backend\Util;
use Illuminate\Database\Eloquent\Model;

class Column extends Fluent
{
    use InheritParentAttrs;

    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'align' => 'left',
        'header' => '',
        'key' => '',
    ];

    /**
     * Subclass constructor aliases
     *
     * @var array
     */
    public static $subclasses = [
        'carbon' => \Bedard\Backend\Columns\CarbonColumn::class,
        'number' => \Bedard\Backend\Columns\NumberColumn::class,
        'text' => \Bedard\Backend\Columns\TextColumn::class,
    ];

    /**
     * Init
     *
     * @param string $key
     *
     * @return void
     */
    public function init(string $key = '')
    {
        $this->attributes['key'] = $key;
    }

    /**
     * Align
     *
     * @param string $header
     *
     * @return \Bedard\Backend\Column
     */
    public function setAlignAttribute(?string $align = null)
    {
        if ($align === null) {
            throw new InvalidColumnAlignmentException("Missing column alignment, please specify \"left\", \"right\", or \"center\".");
        }

        $alignments = ['left', 'right', 'center'];

        $str = trim(strtolower($align));

        if (!in_array($str, $alignments)) {
            $suggestion = Util::suggest($str, $alignments);
            
            throw new InvalidColumnAlignmentException("Invalid column alignment \"{$align}\", did you mean \"{$suggestion}\"?");
        }

        $this->attributes['align'] = $align;
    }
    
    /**
     * Render column
     */
    public function render(Model $model)
    {
        return $model->{$this->key};
    }

    /**
     * Render column header
     */
    public function renderHeader(): string
    {
        return $this->header ?: $this->key;
    }
}