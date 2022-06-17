<?php

namespace Bedard\Backend\Console;

use Bedard\Backend\Console\StubParams;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class ActionCommand extends GeneratorCommand
{
    use StubParams;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backend:action {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an action';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Action';

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $name = $this->getNormalizedName($name);

        $stub = $this->files->get($this->getStub());

        return $this->replaceParams($stub, [
            'class' => $this->getClassParam($name),
            'id' => $this->getIdParam($name),
        ]);  
    }

    /**
     * Class param
     *
     * @param string $name
     *
     * @return string
     */
    protected function getClassParam(string $name)
    {
        return $name . 'Action';
    }

    /**
     * Action param
     *
     * @param string $name
     *
     * @return string
     */
    protected function getIdParam(string $name)
    {
        return Str::kebab($name);
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return $this->getClassParam($this->getNormalizedName());
    }

    /**
     * Guess the name of the action.
     *
     * @return string
     */
    protected function getNormalizedName()
    {
        $name = trim($this->argument('name'));

        if (Str::endsWith($name, 'Action')) {
            $name = Str::substr($name, 0, -8);
        }

        return Str::studly(Str::singular($name));
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Backend\Actions';
    }

    /**
     * Get stub.
     *
     * @return string
     */
    public function getStub()
    {
        return realpath(__DIR__ . '/stubs/action.stub');
    }
}
