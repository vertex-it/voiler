<?php

namespace VertexIT\Voiler\Casts;

use VertexIT\Voiler\Services\MediaSingleService;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class MediaSingleResponsive implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return MediaSingleService::get($model, $key, $value, $attributes);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return MediaSingleService::set($model, $key, $value, $attributes);
    }
}
