<?php

namespace Bedard\Backend\Http\Controllers;

use Backend;
use Bedard\Backend\Http\Controllers\Controller;
use Bedard\Backend\Resources\AdminResource;
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
        return [
            'foo' => 'bar',
        ];
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

        return view('backend::admin', [
            'data' => $results,
            'resource' => $resource,
            'table' => $table->provide($data),
        ]);
    }
}
