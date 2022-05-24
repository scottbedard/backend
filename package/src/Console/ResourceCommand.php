<?php

namespace Bedard\Backend\Console;

use Bedard\Backend\Console\StubParams;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class ResourceCommand extends GeneratorCommand
{
    use StubParams;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backend:resource {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a backend resource';

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
        $stub = $this->files->get($this->getStub());

        $model = $this->getModelParam();

        return $this->replaceParams($stub, [
            'class' => $this->getClassParam($model),
            'id' => $this->getIdParam($model),
            'model' => $model,
            'title' => $this->getTitleParam($model),
        ]);  
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Backend\Resources';
    }

    /**
     * Resource class param.
     *
     * @param string $model
     *
     * @return string
     */
    protected function getClassParam(string $model)
    {
        return $model . 'Resource';
    }

    /**
     * Resource ID param.
     *
     * @param string $model
     *
     * @return string
     */
    protected function getIdParam(string $model)
    {
        return Str::plural(Str::kebab($model));
    }

    /**
     * Guess the model name of a resource.
     *
     * @param string
     */
    protected function getModelParam()
    {
        $name = trim($this->argument('name'));

        if (Str::endsWith($name, 'Resource')) {
            $name = Str::substr($name, 0, -8);
        }

        return Str::studly(Str::singular($name));
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return $this->getClassParam($this->getModelParam());
    }

    /**
     * Resource title param.
     *
     * @param string $model
     *
     * @return string
     */
    protected function getTitleParam(string $model)
    {
        return Str::plural(Str::words($model));
    }

    /**
     * Get stub.
     *
     * @return string
     */
    public function getStub()
    {
        return realpath(__DIR__ . '/stubs/resource.stub');
    }
}
