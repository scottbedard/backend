<?php

namespace App\Backend\Resources;

use Bedard\Backend\Column;
use Bedard\Backend\Field;
use Bedard\Backend\Resource;

class PostResource extends Resource
{
    /**
     * Unique resource identifier.
     *
     * @var string
     */
    public static $id = 'posts';

    /**
     * Resource icon.
     *
     * See https://lucide.dev/
     *
     * @var string
     */
    public static $icon = 'pencil';
  
    /**
     * The model corresponding to this resource.
     *
     * @var string
     */
    public static $model = \App\Models\Post::class;

    /**
     * Resource title.
     *
     * @var string
     */
    public static $title = 'Posts';

    /**
     * Fields
     *
     * @return array
     */
    public function fields()
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
    public function schema()
    {
        return [
            Column::number('id')->header('ID'),

            Column::text('title')->header('Title'),

            Column::text('created_at')->header('Created'),

            Column::text('updated_at')->header('Updated'),
        ];
    }
}
