<?php

namespace Bedard\Backend;

use Bedard\Backend\Exceptions\UnknownColumnPropertyException;
use Bedard\Backend\Exceptions\UnknownColumnTypeException;
use Bedard\Backend\Util;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Column
{
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
     * Set column properties
     *
     * @param string $name
     * @param array $args
     */
    public function __call($name, array $args = [])
    {
        if (!method_exists($this, $name)) {
            if (property_exists($this, $name)) {
                $this->{$name} = $args[0];
            } else {
                $suggestion = Util::suggest($name, array_keys(get_object_vars($this)));
                
                throw new UnknownColumnPropertyException("Unknown column property \"{$name}\", did you mean \"{$suggestion}\"?");
            }
        }

        return $this;
    }

    /**
     * Construct common column types.
     *
     * @param string $column
     * @param array $args
     *
     * @return \Bedard\Backend\Column
     */
    public static function __callStatic(string $type, array $args = [])
    {
        $common = [
            'carbon' => \Bedard\Backend\Columns\CarbonColumn::class,
            'number' => \Bedard\Backend\Columns\NumberColumn::class,
            'text' => \Bedard\Backend\Columns\TextColumn::class,
        ];

        if (Arr::exists($common, $type)) {
            return new ($common[$type])(...$args);
        }

        $suggestion = Util::suggest($type, array_keys($common));

        throw new UnknownColumnTypeException("Unknown column type \"{$type}\", did you mean \"{$suggestion}\"?");
    }

    /**
     * Construct
     *
     * @param string $key
     *
     * @return void
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * Construct a generic column.
     *
     * @param string $key
     *
     * @return \Bedard\Backend\Column
     */
    public static function make(string $key)
    {
        return new static($key);
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
            
            throw new \Exception("Invalid column alignment \"{$align}\", did you mean \"{$suggestion}\"?");
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
            'header' => $this->header ?: $this->column,
        ]);
    }
}