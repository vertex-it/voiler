<?php

namespace VertexIT\Voiler\Http\Controllers;

use App\Http\Controllers\Controller;
use VertexIT\Voiler\Services\GuesserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected array $resource;

    public function __construct()
    {
        $this->resource = GuesserService::fromControllerName($this::class);
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', $this->resource['model_fqn']);

        if ($request->ajax()) {
            return (new $this->resource['datatable_service_fqn'])->make($request);
        }

        return view(
            $this->resource['view_full_path'] . '.index',
            new $this->resource['index_view_model_fqn']
        );
    }

    public function create()
    {
        $this->authorize('create', $this->resource['model_fqn']);

        return view(
            $this->resource['view_full_path'] . '.form',
            new $this->resource['form_view_model_fqn'](new $this->resource['model_fqn'])
        );
    }

    public function store(): RedirectResponse
    {
        $this->authorize('create', $this->resource['model_fqn']);

        $request = app($this->resource['request_fqn']);

        $model = $this->resource['model_fqn']::createWithRelations($request);

        $this->dispatchEvent('store', $model);

        return $this->redirectWithMessage('store', $model);
    }

    public function edit($model)
    {
        $model = $this->resource['model_fqn']::findByRouteKeyName($model)->first();

        $this->authorize('update', $model);

        return view(
            $this->resource['view_full_path'] . '.form',
            new $this->resource['form_view_model_fqn']($model)
        );
    }

    public function update(Request $request, $model): RedirectResponse
    {
        $this->authorize('update', $this->resource['model_fqn']::findByRouteKeyName($model)->first());

        [$request, $model] = $this->bindModelAndValidateRequest($request, $model);

        $model->updateWithRelations($request);

        $this->dispatchEvent('update', $model);

        return $this->redirectWithMessage('update', $model);
    }

    public function destroy($model): JsonResponse
    {
        $model = $this->resource['model_fqn']::findByRouteKeyName($model);

        $this->authorize('delete', $model->first());

        $model->delete();

        $this->dispatchEvent('destroy');

        return response()->json(true);
    }

    public function restore(Request $request): JsonResponse
    {
        $model = $this->resource['model_fqn']::withTrashed()->findOrFail($request->id);

        $this->authorize('restore', $model);

        $model->restore();

        $this->dispatchEvent('restore');

        return response()->json(true);
    }

    public function updatePriority(Request $request): JsonResponse
    {
        $this->resource['model_fqn']::where('id', $request->id)
            ->update([
                'priority' => $request->priority,
            ]);

        return response()->json(true);
    }

    public function forceDelete(Request $request): JsonResponse
    {
        $model = $this->resource['model_fqn']::withTrashed()->findOrFail($request->id);

        $this->authorize('forceDelete', $model);

        $model->forceDeleteWithRelations();

        $this->dispatchEvent('forceDelete');

        return response()->json(true);
    }

    public function redirectWithMessage($action, $model): RedirectResponse
    {
        flashSuccessMessage($action, $model);

        return redirect()->route($this->resource['route_name'] . '.index');
    }

    public function bindModelAndValidateRequest($request, $model): array
    {
        $model = $this->resource['model_fqn']::findByRouteKeyName($model)->first();

        $request->merge([
            $this->resource['name_singular'] => $model,
        ]);

        $request = app($this->resource['request_fqn']);

        return [$request, $model];
    }

    protected function dispatchEvent($action, $modelRecord = null): void
    {
    }
}
