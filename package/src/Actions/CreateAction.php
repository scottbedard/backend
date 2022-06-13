<?php

namespace Bedard\Backend\Actions;

use Bedard\Backend\Actions\Action;

class CreateAction extends Action
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'id' => 'create',
        'permission' => '',
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

        return redirect(route('backend.resources.show', ['id' => $resource::$id]));
    }
}