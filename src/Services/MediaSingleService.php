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
        if (! $model->exists || ! $value) {
            return $value;
        }

        if (str_contains($value, config('app.url') . '/storage')) {
            $adder = $model->addMediaFromDisk(str_replace(config('app.url') . '/storage', '', $value), 'public');

            if (! str_contains($value, config('app.url') . '/storage/temp') || config('voiler.media_library.preserve_temp_files')) {
                $adder = $adder->preservingOriginal();
            }

            $adder->toMediaCollection($key);
        } else {
            // TODO investigate, delete?
            $model->addMediaFromUrl($value)->toMediaCollection($key);
        }

        return $model->getFirstMediaUrl($key);
    }
}
