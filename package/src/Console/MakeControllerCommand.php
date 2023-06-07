<?php

namespace Bedard\Backend\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeControllerCommand extends Command
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a backend controller';

    /**
     * Construct.
     *
     * @var string
     */
    public function __construct()
    {
        $this->signature = '
            backend:make-controller {name}
            {--f|force : Overwrite existing files}
            {--d|docs : Add documentation comments}
        ';

        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $stub = File::get(__DIR__ . '/stubs/controller.yaml.stub');

        $output = '';
        $lines = explode(PHP_EOL, $stub);

        $name = $this->argument('name');
        $singular = strtolower(Str::singular($name));
        $plural = strtolower(Str::plural($name));

        foreach ($lines as $line) {
            // remove comments
            if (!$this->option('docs') && str_contains($line, '#')) {
                continue;
            }

            $output .= $line . PHP_EOL;
        }

        // create output directory if necessary
        $dir = config('backend.backend_directory');

        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir);
        }

        // replace entities
        $output = str_replace(':singular', $singular, $output);
        $output = str_replace(':plural', $plural, $output);
        $output = str_replace(':model', ucfirst($singular), $output);

        // output the file
        $path = $dir . '/' . $plural . '.yaml';

        if (!$this->option('force') && File::exists($path)) {
            if (!$this->confirm('Controller "' . $plural . '.yaml" already exists. Overwrite?')) {
                return;
            }
        }

        $filename = $plural . '.yaml';

        File::put($dir . '/' . $filename, $output);

        $this->info('Created ' . $plural . ' controller!');
    }
}
