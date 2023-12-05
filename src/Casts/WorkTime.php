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
     * @throws \JsonException
     */
    public function get($model, string $key, $value, array $attributes): mixed
    {
        return json_decode($value ?? '{}', true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     * @return string|bool
     * @throws \JsonException
     */
    public function set($model, string $key, $value, array $attributes): string|bool
    {
        return json_encode(array_map(static function($day) {
            return prepareMultipleInputData($day);
        }, $value), JSON_THROW_ON_ERROR);
    }
}
