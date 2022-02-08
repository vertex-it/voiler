<?php

namespace VertexIT\Voiler\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

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
    public function get($model, string $key, $value, array $attributes): mixed
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
     * @return string|bool
     */
    public function set($model, string $key, $value, array $attributes): string|bool
    {
        return json_encode(
            array_map(function ($day) {
                return prepareMultipleInputData($day);
            }, $value)
        );
    }
}
