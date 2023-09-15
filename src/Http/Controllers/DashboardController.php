<?php

namespace VertexIT\Voiler\Http\Controllers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('voiler::dashboard');
    }
}
