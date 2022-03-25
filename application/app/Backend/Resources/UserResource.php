<?php

namespace App\Backend\Resources;

use Bedard\Backend\Field;
use Bedard\Backend\Resource;

class UserResource extends Resource
{
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
    public static $model = \App\Models\User::class;

    /**
     * Resource route.
     *
     * @var string
     */
    public static $route = 'users';

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
}
