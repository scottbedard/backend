<?php

namespace Bedard\Backend;

use Bedard\Backend\Classes\Fluent;
use Bedard\Backend\Exceptions\InvalidColumnAlignmentException;
use Bedard\Backend\Util;
use Illuminate\Database\Eloquent\Model;

class Column extends Fluent
{
    /**
     * Constructors.
     *
     * @var array
     */
    public static array $constructors = [
        'carbon' => \Bedard\Backend\Columns\CarbonColumn::class,
        'number' => \Bedard\Backend\Columns\NumberColumn::class,
        'text' => \Bedard\Backend\Columns\TextColumn::class,
    ];

    /**
     * Align
     *
     * @var string
     */
    public string $align = 'left';

    /**
     * Header
     *
     * @var string
     */
    public string $header = '';

    /**
     * Key
     *
     * @var string
     */
    public string $key = '';

    /**
     * Construct
     *
     * @param string $key
     *
     * @return void
     */
    public function __construct(string $key = '')
    {
        $this->key = $key;
    }

    /**
     * Align
     *
     * @param string $header
     *
     * @return \Bedard\Backend\Column
     */
    public function align(string $align)
    {
        $alignments = [
            'center', 
            'left', 
            'right',
        ];

        $str = trim(strtolower($align));

        if (!in_array($str, $alignments)) {
            $suggestion = Util::suggest($str, $alignments);
            
            throw new InvalidColumnAlignmentException("Invalid column alignment \"{$align}\", did you mean \"{$suggestion}\"?");
        }

        $this->align = $align;

        return $this;
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
    public function renderHeader()
    {
        return view('backend::columns.default-header', [
            'align' => $this->align,
            'header' => $this->header ?: $this->key,
        ]);
    }
}