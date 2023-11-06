<?php

namespace VertexIT\Voiler\Services\Datatable;

use App\Models\User;
use Illuminate\Http\Request;
use VertexIT\Voiler\Services\BaseDatatableService;

class UserDatatableService extends BaseDatatableService
{
    public function prepareQuery(Request $request)
    {
        return User::where('id', '!=', auth()->id())->withTrashed();
    }
}
