<?php

namespace VertexIT\Voiler\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class OptimizeWithSquoosh implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $filePath)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $process = new Process([
            'npx',
            '@frostoven/squoosh-cli',
            '--webp',
            'auto',
            $this->filePath,
        ]);
        $process->setWorkingDirectory(dirname($this->filePath));

        try {
            $process->mustRun();
        } catch (ProcessFailedException $exception) {
            //
        }
    }
}
