<?php

namespace Bedard\Backend\Console;

use Illuminate\Console\Command;

class ControllerCommand extends Command
{
    /**
     * Construct.
     *
     * @var string
     */
    public function __construct()
    {
        $this->description = trans('backend::console.controller.description');

        $this->signature = '
            backend:controller {name}
            {--d|docs : ' . trans('backend::console.controller.docs') . '}
            {--m|model : ' . trans('backend::console.controller.model') . '}
            {--t|terse : ' . trans('backend::console.controller.terse') . '}
        ';

        parent::__construct();
    }

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a backend controller';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //
    }
}
