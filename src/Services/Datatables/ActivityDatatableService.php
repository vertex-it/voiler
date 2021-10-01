<?php

namespace VertexIT\Voiler\Services\Datatables;

use Illuminate\Http\Request;
use VertexIT\Voiler\Models\Activity;
use Yajra\DataTables\Facades\DataTables;
use VertexIT\Voiler\Services\BaseDatatableService;
use VertexIT\Voiler\ViewModels\Index\ActivityIndexViewModel;

class ActivityDatatableService extends BaseDatatableService
{
    public function make(Request $request)
    {
        return DataTables::eloquent($this->prepareQuery($request))
            ->addColumn('action', function ($activity) {
                return view('voiler::admin.activity.action', new ActivityIndexViewModel($activity));
            })
            ->make();
    }

    public function prepareQuery(Request $request)
    {
        return Activity::query()->with(['causer:id,name', 'subject:id,slug']);
    }
}