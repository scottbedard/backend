<?php

namespace Bedard\Backend\Http\Controllers;

use Backend;
use Bedard\Backend\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourcesController extends Controller
{
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
            return abort(401);
        }

        $model = new $resource::$model;

        $form = $resource->form();

        return view('backend::resources-create', [
            'fields' => $form->fields,
            'model' => $model,
            'resource' => $resource,
        ]);
    }

    /**
     * Destroy
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function destroy(Request $request, string $id)
    {
        $user = Auth::user();

        $resource = Backend::resource($id);

        if (!Backend::check($user, 'delete ' . $resource::$id)) {
            return abort(401);
        }

        $resource->delete($request->post('resource'));

        return redirect(route('backend.resources.show', [
            'id' => $id,
        ]));
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

        if (!Backend::check($user, ...$resource->permissions())) {
            return abort(401);
        }

        $rows = $resource->query()->get();

        return view('backend::resource-index', [
            'data' => $rows,
            'resource' => $resource,
            'table' => fn () => $resource->table()->provide([
                'resource' => $resource,
                'rows' => $rows,
            ]),
            'toolbar' => fn () => $resource->toolbar()->provide($rows),
        ]);

        // return view('backend::resources-show', [
        //     'columns' => $table->columns,
        //     'data' => $resource->data(),
        //     'resource' => $resource,
        //     'selectable' => $table->selectable,
        //     'toolbar' => $toolbar,
        // ]);
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
    public function update(Request $request, string $id, mixed $modelId)
    {
        $user = Auth::user();

        $resource = Backend::resource($id);

        if (!Backend::check($user, 'update ' . $resource::$id)) {
            return abort(401);
        }

        $model = $resource
            ->query()
            ->where($resource::$modelKey, $modelId)
            ->firstOrFail();

        $form = $resource->form();

        return view('backend::resources-update', [
            'fields' => $form->fields,
            'model' => $model,
            'resource' => $resource,
        ]);
    }
}
