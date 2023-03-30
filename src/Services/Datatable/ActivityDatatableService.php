<?php

namespace VertexIT\Voiler\Services\Datatable;

use Illuminate\Http\Request;
use VertexIT\Voiler\Models\Activity;
use VertexIT\Voiler\Services\BaseDatatableService;
use VertexIT\Voiler\ViewModels\Index\ActivityIndexViewModel;
use Yajra\DataTables\Facades\DataTables;

class ActivityDatatableService extends BaseDatatableService
{
    public function make(Request $request)
    {
        return DataTables::eloquent($this->prepareQuery($request))
            ->addColumn('action', function ($activity) {
                return view('voiler::admin.activity.action', new ActivityIndexViewModel($activity));
            })
            ->addColumn('created_at_formatted', function ($activity) {
                return $activity->created_at->format('d. M Y - H:i\h');
            })
            ->make();
    }

    public function prepareQuery(Request $request)
    {
        return Activity::query()->with(['causer:id,name', 'subject:id,slug']);
    }
}
