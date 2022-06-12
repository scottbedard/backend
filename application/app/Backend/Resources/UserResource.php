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

class UserResource extends Resource
{
    /**
     * Application entity.
     *
     * @var string
     */
    public static $entity = 'User';

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
     * Form
     *
     * @return array
     */
    public function form(): Form
    {
        return Form::fields([
            Field::input('id')
                ->label('ID')
                ->readonly()
                ->required(),

            Field::input('name')
                ->label('Name')
                ->span(6)
                ->required(),

            Field::input('email')
                ->label('Email address')
                ->span(6)
                ->required(),

            Field::input('created_at')
                ->label('Created at')
                ->span(6),

            Field::input('updated_at')
                ->label('Last seen')
                ->span(6),

            Toolbar::align('between')->items([
                Link::text('Cancel')
                    ->iconLeft('arrow-left')
                    ->href(route('backend.resources.show', ['id' => 'users'])),

                Button::type('submit')
                    ->icon('save')
                    ->theme('primary')
                    ->text('Save user'),
            ]),
        ]);
    }

    /**
     * Table definition.
     *
     * @return \Bedard\Backend\Table
     */
    public function table(): Table
    {
        $table = Table::columns([
                Column::make('name')
                    ->header('Name'),

                Column::make('email')
                    ->header('Email address'),

                Column::date('created_at')
                    ->align('right')
                    ->header('Created at'),

                Column::date('updated_at')
                    ->align('right')
                    ->header('Last seen')
                    ->diffForHumans(),
            ])
            ->selectable()
            ->pageSize(20);

        return $table;
    }

    /**
     * Toolbar definition.
     *
     * @return \Illuminate\View\View
     */
    public function toolbar(): Toolbar
    {
        return Toolbar::items([
                Button::permission('create users')
                    ->theme('primary')
                    ->icon('plus')
                    ->text('Create user')
                    ->to(route('backend.resources.create', ['id' => static::$id])),

                Button::permission('delete users')
                    ->action('delete')
                    ->icon('trash')
                    ->text('Delete selected')
                    ->requireSelection()
                    ->confirm([
                        'buttonIcon' => 'trash',
                        'buttonText' => 'Confirm delete',
                        'buttonTheme' => 'danger',
                        'secondaryIcon' => 'arrow-left',
                        'secondaryText' => 'Cancel',
                        'text' => 'Are you sure you want to permenantly delete these users?',
                        'title' => 'Delete users',
                    ]),
            ]);
    }
}
