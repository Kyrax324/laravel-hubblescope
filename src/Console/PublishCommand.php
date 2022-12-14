<?php

namespace Hubblescope\Console;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hubblescope:publish {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish all of the hubblescope resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('vendor:publish', [
            '--tag' => 'hubblescope-config',
            '--force' => $this->option('force'),
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'hubblescope-assets',
            '--force' => true,
        ]);
    }
}
