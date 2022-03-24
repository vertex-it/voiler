<?php

namespace VertexIT\Voiler\Services;

class MediaSingleService
{
    public static function get($model, string $key, $value, array $attributes)
    {
        return $value;
    }

    public static function set($model, string $key, $value, array $attributes)
    {
        return $value;

        if (! $model->exists || ! $value) {
            return $value;
        }

        if (str_contains($value, config('app.url') . '/storage')) {
            $adder = $model->addMediaFromDisk(str_replace(config('app.url') . '/storage', '', $value), 'public');

            if (! str_contains($value, config('app.url') . '/storage/temp')) {
                $adder = $adder->preservingOriginal();
            }

            $adder->toMediaCollection($key);
        } else {
            $model->addMediaFromUrl($value)->toMediaCollection($key);
        }

        return $model->getFirstMediaUrl($key);
    }
}
