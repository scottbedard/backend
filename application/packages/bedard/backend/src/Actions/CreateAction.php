<?php

namespace Bedard\Backend\Actions;

use Bedard\Backend\Actions\Action;
use Bedard\Backend\Classes\Alert;
use Bedard\Backend\Resource;

class CreateAction extends Action
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'id' => 'create',
        'permission' => null,
    ];

    /**
     * Handle
     *
     * @param Bedard\Backend\Resource $resource
     * @param \App\Models\User $user
     * @param array $data
     *
     * @return mixed
     */
    public function handle($resource, $user, $data = [])
    {
        $model = new $resource::$model;
        
        foreach ($data['form'] as $field => $value) {
            $model->{$field} = $value;
        }
        
        $model->timestamps = false;
        
        $model->save();

        Alert::success("Successfully created " . strtolower($resource::$entity));

        return redirect(route('backend.resources.show', ['id' => $resource::$id]));
    }

    /**
     * Init
     *
     * @param \Bedard\Backend\Resource|string $arg
     *
     * @return void
     */
    public function init($arg = null)
    {
        $this->attributes['permission'] = is_a($arg, Resource::class) ? "create {$arg::$id}" : $arg;
    }
}
