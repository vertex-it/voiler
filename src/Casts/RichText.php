<?php

namespace VertexIT\Voiler\Casts;

use App\Services\RichTextMediaLibraryImagesService;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

// TODO: Extract to Voiler
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
    public function get($model, $key, $value, $attributes)
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
     * @return mixed
     */
    public function set($model, $key, $value, $attributes)
    {
        return (
            new RichTextMediaLibraryImagesService($model, $key, $value)
        )->processImagesUpload();
    }
}
