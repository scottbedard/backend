<?php

namespace App\Backend\Resources;

use Bedard\Backend\Actions\Action;
use Bedard\Backend\Components\Button;
use Bedard\Backend\Components\Column;
use Bedard\Backend\Components\Field;
use Bedard\Backend\Components\Form;
use Bedard\Backend\Components\Group;
use Bedard\Backend\Components\Link;
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
     * Actions
     *
     * @return array
     */
    public function actions()
    {
        return [
            Action::create($this),
            Action::delete($this),
            Action::update($this),
        ];
    }

    /**
     * Form
     *
     * @return array
     */
    public function form(): Form
    {
        return Form::fields([
            Field::input('id')
                ->context('update')
                ->label('ID')
                ->readonly()
                ->required(),

            Field::input('name')
                ->label('Name')
                ->span(6)
                ->required(),

            Field::input('email')
                ->type('email')
                ->label('Email address')
                ->span(6)
                ->required(),

            Field::input('password')
                ->context('create')
                ->type('password')
                ->label('Password')
                ->span(6)
                ->required(),

            Field::date('created_at')
                ->context('update')
                ->label('Created at')
                ->span(6),

            Field::date('updated_at')
                ->context('update')
                ->label('Last seen')
                ->span(6),

            Toolbar::align('between')->items([
                Link::text('Cancel')
                    ->iconLeft('arrow-left')
                    ->href(route('backend.resources.show', ['id' => 'users'])),

                Group::gap()->items([
                    Button::permission('delete users')
                        ->action('delete')
                        ->icon('trash')
                        ->text('Delete user')
                        ->confirm([
                            'buttonIcon' => 'trash',
                            'buttonText' => 'Confirm delete',
                            'buttonTheme' => 'danger',
                            'data' => fn ($data) => view('backend::renderables.form-delete-data', $data),
                            'secondaryIcon' => 'arrow-left',
                            'secondaryText' => 'Cancel',
                            'text' => 'Are you sure you want to permenantly delete this user?',
                            'title' => 'Delete user',
                        ]),

                    Button::type('submit')
                        ->icon('save')
                        ->theme('primary')
                        ->text('Save user'),
                ]),
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
