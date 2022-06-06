<?php

namespace Bedard\Backend;

use Bedard\Backend\Table;

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
     * Table data.
     */
    public function data()
    {
        $query = static::$model::query();

        return $query->get();
    }

    /**
     * Form.
     *
     * @return array
     */
    public function form()
    {
        return [
            // ...
        ];
    }

    /**
     * Permissions that will allow a user to access this resource.
     *
     * @return array
     */
    public function permissions()
    {
        $id = static::$id;

        return [
            "create {$id}",
            "delete {$id}",
            "manage {$id}",
            "read {$id}",
            "update {$id}",
        ];
    }

    /**
     * Table definition.
     *
     * @return \Bedard\Backend\Table
     */
    public function table(): Table
    {
        return Table::make();
    }
}
