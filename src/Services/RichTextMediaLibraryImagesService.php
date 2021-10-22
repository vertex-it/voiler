<?php

namespace VertexIT\Voiler\Services;

use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class RichTextMediaLibraryImagesService
{
    public function __construct($model, $key, $html)
    {
        $this->model = $model;
        $this->key = $key;
        $this->html = $html;
    }

    public function processImagesUpload()
    {
        if ($this->model->exists) {
            return $this->uploadImages();
        }

        return $this->html;
    }

    public function uploadImages()
    {
        [$keptImages, $newImages] = $this->fetchImgSrc();

        $keptImagesCollection = $this->model
            ->getMedia($this->key)
            ->filter(function ($media) use ($keptImages) {
                return in_array($media->getUrl(), $keptImages);
            });

        $this->model->clearMediaCollectionExcept($this->key, $keptImagesCollection);

        foreach ($newImages as $imageTempPath) {
            $media = $this->model
                ->addMediaFromUrl(url($imageTempPath))
                ->toMediaCollection($this->key);

            $this->html = str_replace(
                $imageTempPath,
                $media->getUrl(),
                $this->html
            );
        }

        return $this->html;
    }

    public function fetchImgSrc()
    {
        $crawler = new Crawler($this->html);

        $images = $crawler->filter('img')->each(function ($img) {
            return $img->attr('src');
        });

        $keptImages = [];
        $newImages = [];
        foreach ($images as $imageUrl) {
            if (Str::contains($imageUrl, '/storage/temp/')) {
                $newImages[] = $imageUrl;
            } else {
                $keptImages[] = url($imageUrl);
            }
        }

        return [$keptImages, $newImages];
    }
}
