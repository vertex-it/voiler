<?php

namespace VertexIT\Voiler\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use VertexIT\Voiler\Services\RichTextMediaLibraryImagesService;

class RichText implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes): mixed
    {
        return $value;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     * @return string|array
     */
    public function set($model, string $key, $value, array $attributes): string|array
    {
        return (
            new RichTextMediaLibraryImagesService($model, $key, $value)
        )->processImagesUpload();
    }
}
