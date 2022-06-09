<?php

namespace Bedard\Backend;

use Bedard\Backend\Form;
use Bedard\Backend\Table;
use Bedard\Backend\Toolbar;

class Resource
{
    /**
     * Application entity
     *
     * @var string
     */
    public static $entity = '';

    /**
     * Unique resource identifier
     *
     * @var string
     */
    public static $id = '';

    /**
     * Resource icon
     *
     * See https://lucide.dev/
     *
     * @var string
     */
    public static $icon = 'smile';
  
    /**
     * The model corresponding to this resource
     *
     * @var string
     */
    public static $model = null;

    /**
     * Resource order
     *
     * @var int
     */
    public static $order = 0;

    /**
     * Resource title
     *
     * @var string
     */
    public static $title = null;

    /**
     * Text for the create button
     *
     * @return string
     */
    public function createButtonText()
    {
        return 'Create ' . strtolower(static::$entity);
    }

    /**
     * Table data
     */
    public function data()
    {
        $query = static::$model::query();

        return $query->get();
    }

    /**
     * Delete resources by ID
     *
     * @param array
     *
     * @return void
     */
    public function delete(array $ids)
    {
        static::$model::whereIn('id', $ids)->delete();
    }

    /**
     * Form
     *
     * @return array
     */
    public function form()
    {
        return Form::make();
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
     * Table
     *
     * @return \Bedard\Backend\Table
     */
    public function table(): Table
    {
        return Table::make();
    }

    /**
     * Toolbar
     *
     * @return \Bedard\Backend\Toolbar
     */
    public function toolbar(): Toolbar
    {
        return Toolbar::make();
    }
}
