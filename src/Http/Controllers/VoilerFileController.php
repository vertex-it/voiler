<?php

namespace VertexIT\Voiler\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use VertexIT\Voiler\Services\FileService;

class VoilerFileController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $file = FileService::store(
            $request->file,
            'temp',
            $request->name ?? '',
        );

        return response()->json(Storage::url($file));
    }
}
