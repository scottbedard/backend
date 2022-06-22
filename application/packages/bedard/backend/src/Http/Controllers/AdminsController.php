<?php

namespace Bedard\Backend\Http\Controllers;

use Bedard\Backend\Http\Controllers\Controller;
use Bedard\Backend\Resources\AdminResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminsController extends Controller
{
    /**
     * Create
     *
     * @param \Illuminate\Http\Request $request
     */
    public function create()
    {
        $user = Auth::user();

        $resource = new AdminResource();

        $model = new $resource::$model;

        $form = $resource->form();

        $data = [
            'action' => 'create',
            'context' => 'create',
            'model' => $model,
            'resource' => $resource,
        ];

        return view('backend::admins-show', [
            'form' => $form->provide($data),
            'model' => $model,
            'resource' => $resource,
        ]);
    }

    /**
     * Index
     *
     * @param \Illuminate\Http\Request $request
     */
    public function index()
    {
        $user = Auth::user();
        
        $resource = new AdminResource();

        $table = $resource->table();

        $query = $resource
            ->query()
            ->has('permissions')
            ->orHas('roles');

        $order = $this->applySortOrderToQuery($query, 'id,asc');

        $results = $query->paginate($table->pageSize);

        $data = [
            'order' => $order,
            'resource' => $resource,
            'rows' => $results,
        ];

        return view('backend::admins-index', [
            'data' => $results,
            'resource' => $resource,
            'table' => $table->provide($data),
        ]);
    }

    /**
     * Edit
     * 
     * @param \Illuminate\Http\Request $request
     * @param mixed $modelId
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Request $request, mixed $modelId)
    {
        $user = Auth::user();

        $resource = new AdminResource();

        $model = $resource
            ->query()
            ->where($resource::$modelKey, $modelId)
            ->firstOrFail();

        $data = [
            'action' => 'update',
            'context' => 'update',
            'model' => $model,
            'resource' => $resource,
        ];

        return view('backend::admins-show', [
            'form' => $resource->form()->provide($data),
            'model' => $model,
            'resource' => $resource,
        ]);
    }
}
