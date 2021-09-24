<?php

namespace VertexIT\Voiler\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

// TODO: Extract to Voiler
class WorkTime implements CastsAttributes
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
        return json_decode($value, true);
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
        return json_encode(
            array_map(function ($day) {
                return prepareMultipleInputData($day);
            }, $value)
        );
    }
}
