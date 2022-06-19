<?php

namespace Bedard\Backend\Resources;

use Bedard\Backend\Components\Column;
use Bedard\Backend\Components\Component;
use Bedard\Backend\Components\Field;
use Bedard\Backend\Components\Form;
use Bedard\Backend\Components\Table;
use Bedard\Backend\Resource;

class AdminResource extends Resource
{
    /**
     * Application entity
     *
     * @var string
     */
    public static $entity = 'Admin';

    /**
     * Unique resource identifier
     *
     * @var string
     */
    public static $id = 'admins';

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
    public static $model = \App\Models\User::class;

    /**
     * Resource title
     *
     * @var string
     */
    public static $title = 'Admins';

    /**
     * Form
     *
     * @return \Bedard\Backend\Components\Form
     */
    public function form(): Form
    {
        return Form::fields([
            Field::make('id')->header('ID')->readonly(),
        ]);
    }

    /**
     * Table definition
     *
     * @return \Bedard\Backend\Components\Table
     */
    public function table(): Table
    {
        return Table::make()
            ->toolbar([
                self::createButton(),  
            ])
            ->selectable()
            ->columns([
                Column::make('id')->header('ID'),

                Column::make('name')->header('Name'),

                Column::date('created_at')->header('Created at'),

                Column::date('updated_at')->header('Last updated')->diffForHumans(),
            ]);
    }
}
