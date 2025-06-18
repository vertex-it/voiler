<?php

namespace VertexIT\Voiler\Listeners;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAddedEvent;
use VertexIT\Voiler\Jobs\OptimizeWithSquoosh;

class OptimizeMediaImageListener
{
    /**
     * Handle the event.
     */
    public function handle(MediaHasBeenAddedEvent $event): void
    {
        if (! Str::contains($event->media->mime_type, ['image'])) {
            return;
        }

        OptimizeWithSquoosh::dispatch($event->media->getPath());
    }
}
