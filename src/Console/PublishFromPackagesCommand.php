<?php

namespace VertexIT\Voiler\Console;

use Illuminate\Console\Command;

class PublishFromPackagesCommand extends Command
{
    protected $signature = 'voiler-packages:publish';

    protected $description = 'Install the BlogPackage';

    public function handle()
    {
        $this->info('Publishing...');

        $providers = [
            "Spatie\Activitylog\ActivitylogServiceProvider",
            "Spatie\MediaLibrary\MediaLibraryServiceProvider",
        ];

        foreach ($providers as $provider) {
            $this->call('vendor:publish', ['--provider' => $provider]);
        }
    }
}