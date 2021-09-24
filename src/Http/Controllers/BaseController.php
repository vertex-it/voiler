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
        $this->authorize('viewAny', $this->resource['model']);

        if ($request->ajax()) {
            return $this->resource['datatable_service']::make($request);
            // return AdvertisementDatatableService::make($request);
        }

        return view(
            $this->resource['view'] . '.index',
            new $this->resource['index_view_model']
        );
        // return view('admin.advertisement.index', new AdvertisementIndexViewModel);
    }

    public function create()
    {
        $this->authorize('create', $this->resource['model']);

        return view(
            $this->resource['view'] . '.form',
            new $this->resource['form_view_model'](new $this->resource['model'])
        );
        // return view('admin.advertisement.form',
        //     new AdvertisementFormViewModel(new Advertisement)
        // );
    }

    public function store(): RedirectResponse
    {
        $this->authorize('create', $this->resource['model']);

        $request = app($this->resource['request']);

        $model = $this->resource['model']::createWithRelations($request);

        return $this->redirectWithMessage('store', $model);
    }

    public function edit($model)
    {
        $model = $this->resource['model']::findByRouteKeyName($model)->first();

        $this->authorize('update', $model);

        return view(
            $this->resource['view'] . '.form',
            new $this->resource['form_view_model']($model)
        );
        // return view('admin.advertisement.form',
        //     new AdvertisementFormViewModel($advertisement)
        // );
    }

    public function update(Request $request, $model): RedirectResponse
    {
        $this->authorize('update', $this->resource['model']::findByRouteKeyName($model)->first());

        [$request, $model] = $this->bindModelAndValidateRequest($request, $model);

        $model->updateWithRelations($request);

        return $this->redirectWithMessage('update', $model);
    }

    public function destroy($model): JsonResponse
    {
        $model = $this->resource['model']::findByRouteKeyName($model);

        $this->authorize('delete', $model->first());

        $model->delete();
        // $advertisement->delete();

        return response()->json(true);
    }

    public function restore(Request $request): JsonResponse
    {
        $model = $this->resource['model']::withTrashed()->findOrFail($request->id);

        $this->authorize('restore', $model);

        $model->restore();
        // Advertisement::withTrashed()->findOrFail($request->id)->restore();

        return response()->json(true);
    }

    public function updatePriority(Request $request): JsonResponse
    {
        $this->resource['model']::where('id', $request->id)
            ->update([
                'priority' => $request->priority,
            ]);
        // Advertisement::where('id', $request->id)->update([
        //     'priority' => $request->priority,
        // ]);

        return response()->json(true);
    }

    public function forceDelete(Request $request): JsonResponse
    {
        $model = $this->resource['model']::withTrashed()->findOrFail($request->id);

        $this->authorize('forceDelete', $model);

        $model->forceDeleteWithRelations();
        // $advertisement = Advertisement::withTrashed()->findOrFail($request->id);

        return response()->json(true);
    }

    public function redirectWithMessage($action, $model): RedirectResponse
    {
        flashSuccessMessage($action, $model);

        return redirect()->route($this->resource['route_name'] . '.index');
    }

    public function bindModelAndValidateRequest($request, $model): array
    {
        $model = $this->resource['model']::findByRouteKeyName($model)->first();

        $request->merge([
            $this->resource['name_singular'] => $model,
        ]);

        $request = app($this->resource['request']);

        return [$request, $model];
    }
}
