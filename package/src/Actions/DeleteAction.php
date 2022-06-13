<?php

namespace Bedard\Backend\Actions;

use Bedard\Backend\Actions\Action;

class DeleteAction extends Action
{
    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [
        'id' => 'delete',
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
        $resource
            ->query()
            ->whereIn($resource::$modelKey, $data['models'])
            ->get()
            ->each(fn ($model) => $model->delete());

        return redirect(route('backend.resources.show', ['id' => $resource::$id]));
    }
}