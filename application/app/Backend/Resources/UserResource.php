<?php

namespace App\Backend\Resources;

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
    public function form()
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

            Toolbar::align('right')->items([
            //     Button::text('Hello'),

            //     Button::text('World'),
            ]),
        ]);
        // return Form::fields([
        //     Field::input('id')
        //         ->label('ID')
        //         ->readonly(),
                
        //     Field::input('name')
        //         ->label('Name')
        //         ->autofocus()
        //         ->span([
        //             'lg' => 6,
        //         ]),

        //     Field::input('email')
        //         ->label('Email address')
        //         ->placeholder('Enter email address')
        //         ->type('email')
        //         ->span([
        //             'lg' => 6,
        //         ]),

        //     Field::input('created_at')
        //         ->label('Created')
        //         ->span([
        //             'lg' => 6,
        //         ]),

        //     Field::input('updated_at')
        //         ->label('Last seen')
        //         ->span([
        //             'lg' => 6,
        //         ]),
        // ]);
    }

    /**
     * Table definition.
     *
     * @return \Bedard\Backend\Table
     */
    public function table(): Table
    {
        $table = Table::columns([
                Column::make('name')->header('Name'),

                Column::make('email')->header('Email address'),

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
    public function toolbar()
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
