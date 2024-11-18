<?php

namespace VertexIT\Voiler\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use VertexIT\Voiler\Jobs\OptimizeWithSquoosh;
use VertexIT\Voiler\Services\FileService;

class VoilerFileController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file',
            'is_image' => 'sometimes',
            'resize_width' => 'sometimes|integer',
            'resize_height' => 'sometimes|integer',
        ]);

        $filePath = FileService::store(
            $request->file,
            'temp',
            $request->name ?? '',
        );

        $absolutePath = Storage::path($filePath);
        $webpPath = Str::of($absolutePath)->replace('.jpg', '.webp');

        if ($request->is_image) {
            $image = Image::read($absolutePath);

            if ($request->resize_width || $request->resize_height) {
                $image->scale(
                    width: $request->resize_width,
                    height: $request->resize_height,
                );
            }

            $image->save($webpPath);
            unlink($absolutePath);

            OptimizeWithSquoosh::dispatch($webpPath);
        }

        return response()->json(
            Storage::url(
                Str::of($webpPath)->after('app/public')
            )
        );
    }
}
