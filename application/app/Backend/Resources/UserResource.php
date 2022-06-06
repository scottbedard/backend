<?php

namespace App\Backend\Resources;

use Bedard\Backend\Column;
use Bedard\Backend\Resource;
use Bedard\Backend\Table;
use Bedard\Backend\Toolbar\Button;

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
        return Table::toolbar([
                Button::permission('create users')
                    ->icon('plus')
                    ->text('Create user')
                    ->theme('primary')
                    ->to(route('backend.resources.create', ['id' => 'users'])),

                Button::permission('delete users')
                    ->icon('trash')
                    ->text('Delete users')
                    ->confirmation([
                        'title' => 'Are you sure?',
                        'body' => 'This cannot be undone.',
                        'buttonText' => 'Delete',
                        'buttonIcon' => 'trash',
                        'buttonTheme' => 'danger',
                        'secondaryText' => 'Cancel',
                        'secondaryIcon' => 'arrow-left',
                    ])
                    ->method('delete')
                    ->to(route('backend.resources.delete', ['id' => 'users'])),
            ])
            ->columns([
                Column::text('name')->header('Name'),
    
                Column::text('email')->header('Email address'),
    
                Column::carbon('created_at')->header('Created'),
    
                Column::carbon('updated_at')->header('Last Updated')->diffForHumans(),
            ])
            ->selectable()
            ->pageSize(20);
    }
}
