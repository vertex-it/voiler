<?php

namespace VertexIT\Voiler\Services;

use Illuminate\Support\Str;

class MediaMultipleService
{
    public static function get($model, string $key, $value, array $attributes)
    {
        return json_decode($value, true);
    }

    public static function set($model, string $key, $value, array $attributes)
    {
        // TODO: Remove
        // return json_encode($value);

        $uploadedUrls = array_filter($value ?? []);
        $mediaUrls = $model->{$key} ?? [];

        if (array_diff($mediaUrls, $uploadedUrls) === array_diff($uploadedUrls, $mediaUrls) || ! $model->exists) {
            return json_encode($uploadedUrls);
        }

        $oldMediaUrls = array_intersect($mediaUrls, $uploadedUrls);
        $model->clearMediaCollectionExcept(
            $key,
            $model->getMedia($key)->filter(function ($media) use ($oldMediaUrls) {
                if (in_array($media->getUrl(), $oldMediaUrls)) {
                    return $media;
                }
            })
        );

        $model = $model->fresh();

        // If uploaded urls are not in temp then they will not be uploaded
        foreach ($uploadedUrls as $index => $url) {
            if (str_contains($url, config('app.url') . '/storage/temp/')) {
                $model->addMediaFromDisk(
                    str_replace(config('app.url') . '/storage', '', $url),
                    'public'
                )->toMediaCollection($key);
            }
        }

        foreach ($model->getMedia($key) as $index => $media) {
            if (in_array($media->getUrl(), $uploadedUrls)) {
                $media->order_column = array_search($media->getUrl(), $uploadedUrls);
            } else {
                $tempUrl = config('app.url') . '/storage/temp/' . $media->file_name;
                $media->order_column = array_search($tempUrl, $uploadedUrls);
            }

            $media->save();
        }

        $media = $model->getMedia($key)->map(function ($media) {
            return $media->getUrl();
        })->toArray();

        return json_encode($media);
    }
}
