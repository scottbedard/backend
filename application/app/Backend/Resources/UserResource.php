<?php

namespace App\Backend\Resources;

use Bedard\Backend\Column;
use Bedard\Backend\Field;
use Bedard\Backend\Resource;

class UserResource extends Resource
{
    /**
     * Unique resource identifier.
     *
     * @var string
     */
    public static $id = 'users';

    /**
     * Resource icon.
     *
     * See https://lucide.dev/
     *
     * @var string
     */
    public static $icon = 'users';
  
    /**
     * The model corresponding to this resource.
     *
     * @var string
     */
    public static $model = \App\Models\User::class;

    /**
     * Resource title.
     *
     * @var string
     */
    public static $title = 'Users';

    /**
     * Fields
     *
     * @return array
     */
    public function fields()
    {
        return [
            Field::number('id')->label('id'),
        ];
    }

    /**
     * Table schema
     *
     * @return array
     */
    public function schema()
    {
        return [
            Column::number('id')->header('ID'),

            Column::text('name')->header('Name'),

            Column::text('email')->header('Email address'),

            Column::text('created_at')->header('Created')->align('right'),

            Column::text('updated_at')->header('Updated')->align('right'),
        ];
    }
}
