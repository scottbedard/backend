<?php

namespace App\Backend\Resources;

use Bedard\Backend\Components\Button;
use Bedard\Backend\Components\Column;
use Bedard\Backend\Components\Component;
use Bedard\Backend\Components\Field;
use Bedard\Backend\Components\Form;
use Bedard\Backend\Components\Group;
use Bedard\Backend\Components\Table;
use Bedard\Backend\Resource;

class UserResource extends Resource
{
    /**
     * Application entity
     *
     * @var string
     */
    public static $entity = 'User';

    /**
     * Unique resource identifier
     *
     * @var string
     */
    public static $id = 'users';

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
    public static $title = 'Users';

    public function actions()
    {
        return [
            self::create(),
            self::delete(),
            self::update(),
        ];
    }

    /**
     * Form
     *
     * @return \Bedard\Backend\Components\
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
            ->selectable()
            ->columns([
                Column::make('id')->header('ID'),

                Column::make('name')->header('Name'),

                Column::make('email')->header('Email address'),

                Column::date('created_at')->header('Created at'),

                Column::date('updated_at')->header('Last updated')->diffForHumans(),
            ]);
    }

    /**
     * Toolbar
     *
     * @return \Bedard\Backend\Components\Toolbar
     */
    public function toolbar(): Component
    {
        return Group::gap()->padded()->items([
            Button::permission('create users')
                ->theme('primary')
                ->icon('plus')
                ->text('Create user')
                ->to(route('backend.resources.create', ['id' => static::$id])),

            Button::permission('delete users')
                ->action('delete')
                ->disabled('!checked.includes(true)')
                ->icon('trash')
                ->text('Delete selected')
                ->confirm([
                    'buttonIcon' => 'trash',
                    'buttonText' => 'Confirm delete',
                    'buttonTheme' => 'danger',
                    'data' => fn ($data) => view('backend::renderables.table-confirm-data', $data),
                    'secondaryIcon' => 'arrow-left',
                    'secondaryText' => 'Cancel',
                    'text' => 'Are you sure you want to permenantly delete these users?',
                    'title' => 'Delete users',
                ]),
        ]);
    }
}
