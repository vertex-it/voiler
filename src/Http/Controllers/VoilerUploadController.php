<?php

namespace VertexIT\Voiler\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\ImageManager;
use Intervention\Image\Laravel\Facades\Image;
use VertexIT\Voiler\Jobs\OptimizeWithSquoosh;
use VertexIT\Voiler\Services\FileService;

class VoilerUploadController extends Controller
{
    public function file(Request $request): JsonResponse
    {
        $request->validate(['file' => 'required|file']);

        $uploadDirectory = $request->has('permanent_upload') ? 'uploads' : 'temp';

        $filePath = FileService::store(
            $request->file,
            $uploadDirectory,
            $request->name ?? '',
        );

        return response()->json(
            Storage::url(
                Str::of(Storage::path($filePath))->after('app/public')
            )
        );
    }

    public function image(Request $request): JsonResponse
    {
        $request->validate(['file' => 'required|file']);

        $uploadDirectory = $request->has('permanent_upload') ? 'uploads' : 'temp';

        $filePath = FileService::store(
            $request->file,
            $uploadDirectory,
            $request->name ?? '',
        );

        $absolutePath = Storage::path($filePath);

        $uploadedExtension = $request->file('file')->extension();
        $webpPath = Str::of($absolutePath)->replace('.' . $uploadedExtension, '.webp');

        if ($uploadedExtension === 'heic') {
            $manager = new ImageManager(ImagickDriver::class);
        } else {
            $manager = new ImageManager(GdDriver::class);
        }

        $image = $manager->read($absolutePath);

        if (! config('voiler.images.keep_original')) {
            $image->scaleDown(
                width: config('voiler.images.width'),
                height: config('voiler.images.height'),
            );
        }

        unlink($absolutePath);
        $image->save($webpPath);

        return response()->json(
            Storage::url(
                Str::of($webpPath)->after('app/public')
            )
        );
    }
}
