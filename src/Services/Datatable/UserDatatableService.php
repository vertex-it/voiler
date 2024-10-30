<?php

namespace VertexIT\Voiler\Services\Datatable;

use App\Models\User;
use Illuminate\Http\Request;
use VertexIT\Voiler\Services\BaseDatatableService;

class UserDatatableService extends BaseDatatableService
{
    public function addColumns($datatables)
    {
        return $datatables->editColumn('created_at', function ($car) {
            return $car->created_at->format('d.m.Y - H:i\h');
        });
    }

    public function prepareQuery(Request $request)
    {
        return User::where('id', '!=', auth()->id())->withTrashed();
    }
}
