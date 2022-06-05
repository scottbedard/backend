<?php

namespace App\Backend\Resources;

use Bedard\Backend\Column;
use Bedard\Backend\Resource;
use Bedard\Backend\Table;

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
     * Form
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
     * Table definition.
     *
     * @return \Bedard\Backend\Table
     */
    public function table(): Table
    {
        return Table::columns([
                Column::number('id')->header('ID'),

                Column::text('title')->header('Title'),

                Column::carbon('created_at')->header('Created'),

                Column::carbon('updated_at')->header('Last Updated')->diffForHumans(),
            ])
            ->selectable()
            ->pageSize(20);
    }
}
