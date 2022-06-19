<?php

namespace Bedard\Backend;

use App\Models\User;
use Bedard\Backend\Actions\CreateAction;
use Bedard\Backend\Actions\DeleteAction;
use Bedard\Backend\Actions\UpdateAction;
use Bedard\Backend\Components\Button;
use Bedard\Backend\Components\Component;
use Bedard\Backend\Exceptions\ActionNotFoundException;
use Illuminate\Support\Str;

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
        return [];
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
     * Form
     *
     * @return array
     */
    public function form(): Component
    {
        return Component::make();
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
     * @return \Bedard\Backend\Component
     */
    public function table(): Component
    {
        return Component::make();
    }

    /**
     * Toolbar
     *
     * @return \Illuminate\Contracts\Support\Component
     */
    public function toolbar(): Component
    {
        return Component::make();
    }

    /**
     * Default actions
     */
    public static function create()
    {
        return CreateAction::make(self::class);
    }

    public static function delete()
    {
        return DeleteAction::make(self::class);
    }

    public static function update()
    {
        return UpdateAction::make(self::class);
    }

    /**
     * Default buttons
     */
    public static function createButton(array $options = [])
    {
        $icon = data_get($options, 'icon', 'plus');
        $permission = data_get($options, 'permission', 'create' . self::$id);
        $text = data_get($options, 'text', 'Create ' . Str::singular(self::$entity));

        return Button::primary()
            ->icon($icon)
            ->permission($permission)            
            ->text($text)
            ->to(route('backend.resources.create', ['id' => static::$id]));
    }

    public static function deleteButton(array $options = [])
    {
        $permission = data_get($options, 'permission', 'delete' . self::$id);
        $action = data_get($options, 'action', 'delete');
        $icon = data_get($options, 'icon', 'trash');
        $text = data_get($options, 'text', 'Delete selected');
        
        return Button::permission($permission)
            ->action($action)
            ->disabled('!checked.includes(true)')
            ->icon($icon)
            ->id('delete')
            ->text($text)
            ->confirm([
                'buttonIcon' => 'trash',
                'buttonText' => 'Confirm delete',
                'buttonTheme' => 'danger',
                'data' => fn ($data) => view('backend::renderables.table-confirm-data', $data),
                'secondaryIcon' => 'arrow-left',
                'secondaryText' => 'Cancel',
                'text' => 'Are you sure you want to permenantly delete these ' . Str::plural(self::$entity) . '?',
                'title' => 'Delete ' . Str::plural(self::$entity),
            ]);
    }
}
