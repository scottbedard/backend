<?php

namespace App\Backend\Resources;

use Bedard\Backend\Column;
use Bedard\Backend\Field;
use Bedard\Backend\Form;
use Bedard\Backend\Resource;
use Bedard\Backend\Components\Table;
use Bedard\Backend\Components\Button;
use Bedard\Backend\Components\Toolbar;

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
                ->readonly(),
                
            Field::input('name')
                ->label('Name')
                ->autofocus()
                ->span([
                    'lg' => 6,
                ]),

            Field::input('email')
                ->label('Email address')
                ->placeholder('Enter email address')
                ->type('email')
                ->span([
                    'lg' => 6,
                ]),

            Field::input('created_at')
                ->label('Created')
                ->span([
                    'lg' => 6,
                ]),

            Field::input('updated_at')
                ->label('Last seen')
                ->span([
                    'lg' => 6,
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
        return Table::make();
        // return Table::columns([
        //         Column::text('name')->header('Name'),
    
        //         Column::text('email')->header('Email address'),
    
        //         Column::carbon('created_at')->header('Created'),
    
        //         Column::carbon('updated_at')->header('Last Updated')->diffForHumans(),
        //     ])
        //     ->selectable()
        //     ->pageSize(20);
    }

    /**
     * Toolbar definition.
     *
     * @return \Illuminate\View\View
     */
    public function toolbar()
    {
        return Toolbar::make()
            ->items([
                Button::permissions('create users')
                    ->theme('primary')
                    ->icon('plus')
                    ->text('Create user')
                    ->to(route('backend.resources.create', ['id' => static::$id])),

                Button::permissions('delete users')
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
