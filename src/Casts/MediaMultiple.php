<?php

namespace VertexIT\Voiler\Casts;

use VertexIT\Voiler\Services\MediaMultipleService;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class MediaMultiple implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return MediaMultipleService::get($model, $key, $value, $attributes);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return MediaMultipleService::set($model, $key, $value, $attributes);
    }
}
