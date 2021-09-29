<?php

namespace VertexIT\Voiler\Services;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BaseDatatableService
{
    private array $resource = [];

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
                'voiler::components.action',
                new $this->resource['index_view_model']($model)
            );
        });

        return $datatables->make();
    }

    public function prepareQuery(Request $request)
    {
        return $this->resource['model']::withTrashed();
    }

    public function addColumns($datatables)
    {
    }
}