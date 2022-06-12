<?php

namespace Bedard\Backend;

use App\Models\User;
use Bedard\Backend\Actions\DeleteAction;
use Bedard\Backend\Actions\UpdateAction;
use Bedard\Backend\Components\Block;
use Bedard\Backend\Components\Form;
use Bedard\Backend\Components\Table;
use Bedard\Backend\Components\Toolbar;
use Bedard\Backend\Exceptions\ActionNotFoundException;

class Resource
{
    /**
     * Application entity
     *
     * @var string
     */
    public static $entity = '';

    /**
     * Unique resource identifier
     *
     * @var string
     */
    public static $id = '';

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
    public static $model = null;

    /**
     * Unique model property to find records by
     *
     * @var string
     */
    public static $modelKey = 'id';

    /**
     * Resource order
     *
     * @var int
     */
    public static $order = 0;

    /**
     * Resource title
     *
     * @var string
     */
    public static $title = null;

    /**
     * Execute an action
     *
     * @param \App\Models\User $user
     * @param string $action
     * @param array $data
     */
    public function action(User $user, string $action, array $data = [])
    {
        $instance = collect($this->actions())->firstOrFail(fn ($a) => $a->id === $action);

        if ($instance) {
            return $instance->run($this, $user, $data);
        }
    
        throw new ActionNotFoundException("Action \"{$action}\" not found.");
    }

    /**
     * Actions
     *
     * @return array
     */
    public function actions()
    {
        return [
            DeleteAction::permission('delete users'),
            UpdateAction::permission('update users'),
        ];
    }

    /**
     * Table data
     */
    public function data()
    {
        $query = static::$model::query();

        return $query->get();
    }

    /**
     * Delete resources by ID
     *
     * @param array
     *
     * @return void
     */
    public function delete(array $ids)
    {
        static::$model::whereIn('id', $ids)->delete();
    }

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
     * Permissions that will allow a user to access this resource.
     *
     * @return array
     */
    public function permissions()
    {
        $id = static::$id;

        return [
            "create {$id}",
            "delete {$id}",
            "manage {$id}",
            "read {$id}",
            "update {$id}",
        ];
    }

    /**
     * Query
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return static::$model::query();
    }

    /**
     * Table
     *
     * @return \Bedard\Backend\Table
     */
    public function table(): Table
    {
        return Table::make();
    }

    /**
     * Toolbar
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function toolbar(): Toolbar
    {
        return Toolbar::make();
    }
}
