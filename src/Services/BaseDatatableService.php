<?php

namespace VertexIT\Voiler\Services;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BaseDatatableService
{
    private array $resource;

    public function __construct()
    {
        $this->resource = GuesserService::fromDatatableServiceName($this::class);
    }

    public function make(Request $request)
    {
        $datatables = DataTables::eloquent($this->prepareQuery($request));

        $this->addColumns($datatables);

        $datatables->addColumn('action', function ($model) {
            return view(
                'voiler::components.datatable-action',
                new $this->resource['index_view_model_fqn']($model)
            );
        });

        return $datatables->make();
    }

    public function prepareQuery(Request $request)
    {
        $query = $this->resource['model_fqn']::withTrashed();

        if ((new $this->resource['model_fqn'])->timestamps) {
            return $query->latest();
        }

        return $query;
    }

    public function addColumns($datatables)
    {
    }
}
