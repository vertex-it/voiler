<?php

namespace VertexIT\Voiler\Services;

class MediaMultipleService
{
    public static function get($model, string $key, $value, array $attributes): mixed
    {
        return json_decode($value, true);
    }

    public static function set($model, string $key, $value, array $attributes): bool|string
    {
        $uploadedUrls = array_filter($value ?? []);
        $mediaUrls = $model->{$key} ?? [];

        if (
            ! $model->EVENT_CREATED
            && (
                array_diff($mediaUrls, $uploadedUrls) === array_diff($uploadedUrls, $mediaUrls)
                || ! $model->exists
            )
        ) {
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
        foreach ($uploadedUrls as $url) {
            if (str_contains($url, config('app.url') . '/storage/temp/')) {
                $adder = $model->addMediaFromDisk(
                    str_replace(config('app.url') . '/storage', '', $url),
                    'public'
                );

                if (config('voiler.media_library.preserve_temp_files')) {
                    $adder->preservingOriginal();
                }

                $adder->toMediaCollection($key);
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
