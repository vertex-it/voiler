<?php

namespace VertexIT\Voiler\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use VertexIT\Voiler\Services\GuesserService;

class BaseAPIController extends Controller
{
    protected array $resource;

    public function __construct()
    {
        $this->resource = GuesserService::fromAPIControllerName($this::class);
    }

    public function index()
    {
        // TODO
        // $this->authorize('viewAny', $this->resource['model_fqn']);

        return $this->resource['api_resource_fqn']::collection(
            $this->resource['model_fqn']::latest()
                ->get()
        );
    }

    public function show($model)
    {
        $model = $this->resource['model_fqn']::findByRouteKeyName($model)->firstOrFail();

        // TODO
        // $this->authorize('update', $model);

        return new $this->resource['api_resource_fqn']($model);
    }

    public function store()
    {
        // TODO
        // $this->authorize('create', $this->resource['model_fqn']);

        $request = app($this->resource['request_fqn']);

        $model = $this->resource['model_fqn']::createWithRelations($request);

        $this->dispatchEvent('store', $model);

        return response()->json($model, 201);
    }

    public function update(Request $request, $model)
    {
        // TODO
        // $this->authorize('update', $this->resource['model_fqn']::findByRouteKeyName($model)->firstOrFail());

        [$request, $model] = $this->bindModelAndValidateRequest($request, $model);

        $model->updateWithRelations($request);

        $this->dispatchEvent('update', $model);

        return $model;
    }

    public function destroy($model)
    {
        $model = $this->resource['model_fqn']::findByRouteKeyName($model);

        // TODO
        // $this->authorize('delete', $model->firstOrFail());

        $model->delete();

        $this->dispatchEvent('destroy');

        return response()->json(true);
    }

    public function bindModelAndValidateRequest($request, $model): array
    {
        $model = $this->resource['model_fqn']::findByRouteKeyName($model)->firstOrFail();

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
