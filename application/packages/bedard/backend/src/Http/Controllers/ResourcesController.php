<?php

namespace Bedard\Backend\Http\Controllers;

use Backend;
use Bedard\Backend\Classes\SortOrder;
use Bedard\Backend\Exceptions\ActionNotFoundException;
use Bedard\Backend\Exceptions\InvalidSortOrderException;
use Bedard\Backend\Exceptions\UnauthorizedActionException;
use Bedard\Backend\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourcesController extends Controller
{
    /**
     * Action
     *
     * @param \Illuminate\Http\Request $request
     * @param string $id
     */
    public function action(Request $request, string $id)
    {
        $user = Auth::user();
        
        $resource = Backend::resource($id);

        $id = $request->post('_action');

        $action = collect($resource->actions())->firstWhere(fn ($item) => $item->id === $id);

        if (!$action) {
            throw new ActionNotFoundException($id);
        }

        if (!Backend::check($user, $action->permission)) {
            throw new UnauthorizedActionException($id);
        }
        
        return $action->handle($resource, $user, $request->post());
    }

    /**
     * Create
     * 
     * @param \Illuminate\Http\Request $request
     * @param string $route
     */
    public function create(Request $request, string $id)
    {
        $user = Auth::user();

        $resource = Backend::resource($id);

        if (!Backend::check($user, 'create ' . $resource::$id)) {
            return abort(403); // forbidden
        }

        $model = new $resource::$model;

        $data = [
            'action' => 'create',
            'context' => 'create',
            'model' => $model,
            'resource' => $resource,
        ];

        return view('backend::resources-show', [
            'form' => $resource->form()->provide($data),
            'model' => $model,
            'resource' => $resource,
        ]);
    }

    /**
     * Show
     *
     * @param \Illuminate\Http\Request $request
     * @param string $route
     */
    public function show(Request $request, string $id)
    {
        $user = Auth::user();

        $resource = Backend::resource($id);

        if (!Backend::check($user, 'access ' . $resource::$id)) {
            return abort(403); // forbidden
        }

        $table = $resource->table();
        $toolbar = $resource->toolbar();
        $query = $resource->query();

        $order = $table->defaultOrder;

        try {
            $order = SortOrder::from(request()->query('order'));

            if ($order->direction === 1) {
                $query->orderBy($order->property);
            } elseif ($order->direction === -1) {
                $query->orderByDesc($order->property);
            }
        } catch (InvalidSortOrderException $e) {}
        
        $results = $query->paginate($table->pageSize);

        $data = [
            'order' => $order,
            'resource' => $resource,
            'rows' => $results,
        ];

        return view('backend::resource-index', [
            'data' => $results,
            'resource' => $resource,
            'table' => $table->provide($data),
            'toolbar' => $toolbar->provide($data),
        ]);
    }

    /**
     * Update
     * 
     * @param \Illuminate\Http\Request $request
     * @param string $route
     * @param mixed $modelId
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Request $request, string $id, mixed $modelId)
    {
        $user = Auth::user();

        $resource = Backend::resource($id);

        if (!Backend::check($user, 'update ' . $resource::$id)) {
            return abort(403); // forbidden
        }

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

        return view('backend::resources-show', [
            'form' => $resource->form()->provide($data),
            'model' => $model,
            'resource' => $resource,
        ]);
    }
}
