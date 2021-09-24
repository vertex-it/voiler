<?php

namespace VertexIT\Voiler\Interfaces;

use Illuminate\Http\Request;

interface DatatableServiceInterface
{
    public static function make(Request $request);

    public static function prepareQuery(Request $request);
}