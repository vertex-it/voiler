<?php

namespace VertexIT\Voiler\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class FileService
{
    public static function store(UploadedFile $file, array | string $path, string $name = ''): array | string
    {
        self::makeDirectory($path);

        return $file->storeAs($path, self::getFileNameWithExtension($file, $name));
    }

    public static function delete(array | string $paths): bool
    {
        return Storage::delete($paths);
    }

    public static function makeDirectory(string $path): void
    {
        if (Storage::exists($path)) {
            return;
        }

        if (
            ! mkdir($currentDirectory = Storage::path($path), 0755, true)
            && ! is_dir($currentDirectory)
        ) {
            throw new RuntimeException("Directory $path was not created.");
        }
    }

    public static function getFileNameWithExtension(UploadedFile $file, string $name): string
    {
        return $name === ''
            ? $file->hashName()
            : $name;
    }
}
