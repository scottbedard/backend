<?php

namespace Bedard\Backend\Resources;

use App\Models\User;
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
    public static $icon = 'lock';
  
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
     * @return \Bedard\Backend\Components\
     */
    public function form(): Form
    {
        return Form::fields([
            Field::select('id')
                ->display('name')
                ->label('Administrator')
                ->options(fn ($search) => User::limit(10)->get())
                ->required()
                ->searchable()
                ->span(6),

            Field::input('name')
                ->label('Name')
                ->placeholder('Hello world')
                ->required()
                ->span(6),
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
                self::createButton(['route' => route('backend.admin.create')]),  
            ])
            ->selectable()
            ->columns([
                Column::make('id')
                    ->header('ID')
                    ->sortable(),

                Column::make('name')
                    ->header('Name')
                    ->sortable(),

                Column::date('created_at')
                    ->header('Created at')
                    ->sortable(),

                Column::date('updated_at')
                    ->header('Last updated')
                    ->sortable()
                    ->diffForHumans(),
            ])
            ->to(fn ($row) => route('backend.admin.edit', ['modelId' => $row->id]));
    }
}
