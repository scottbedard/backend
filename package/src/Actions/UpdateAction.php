<?php

namespace Bedard\Backend\Actions;

use Bedard\Backend\Actions\Action;
use Illuminate\Support\Arr;

class UpdateAction extends Action
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'id' => 'update',
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
        $model = $resource
            ->query()
            ->where($resource::$modelKey, $data['_modelId'])
            ->firstOrFail();
        
        foreach ($data['form'] as $field => $value) {
            $model->{$field} = $value;
        }
        
        $model->timestamps = false;
        
        $model->save();

        return redirect(route('backend.resources.show', ['id' => $resource::$id]));
    }
}
