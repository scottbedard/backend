<?php

namespace Bedard\Backend\Console;

use Illuminate\Console\Command;

class ResourceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backend:resource';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a backend resource';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Hello from the resource command');

        return 0;
    }
}
