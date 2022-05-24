<?php

namespace Bedard\Backend;

class Resource
{
    /**
     * Unique resource identifier.
     *
     * @var string
     */
    public static $id = '';

    /**
     * Resource icon.
     *
     * See https://lucide.dev/
     *
     * @var string
     */
    public static $icon = 'smile';
  
    /**
     * The model corresponding to this resource.
     *
     * @var string
     */
    public static $model = null;

    /**
     * Resource order.
     *
     * @var int
     */
    public static $order = 0;

    /**
     * Resource title.
     *
     * @var string
     */
    public static $title = null;

    /**
     * Fields
     *
     * @return array
     */
    public static function fields()
    {
        return [
            // ...
        ];
    }

    /**
     * Table schema
     *
     * @return array
     */
    public static function schema()
    {
        return [
            // ...
        ];
    }
}
