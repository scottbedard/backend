<?php

namespace App\Backend\Resources;

use Bedard\Backend\Components\Link;
use Bedard\Backend\Components\Block;
use Bedard\Backend\Components\Button;
use Bedard\Backend\Components\Column;
use Bedard\Backend\Components\Field;
use Bedard\Backend\Components\Form;
use Bedard\Backend\Components\Table;
use Bedard\Backend\Components\Toolbar;
use Bedard\Backend\Resource;

class PostResource extends Resource
{
    /**
     * Application entity.
     *
     * @var string
     */
    public static $entity = 'Post';

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
    public function form(): Form
    {
        return Form::make();
    }

    /**
     * Table definition.
     *
     * @return \Bedard\Backend\Table
     */
    public function table(): Table
    {
        return Table::columns([
                Column::make('id')->header('ID'),

                Column::make('title')->header('Title'),

                Column::date('created_at')->header('Created'),

                Column::date('updated_at')->header('Last Updated')->diffForHumans(),
            ])
            ->selectable()
            ->pageSize(20);
    }
}
