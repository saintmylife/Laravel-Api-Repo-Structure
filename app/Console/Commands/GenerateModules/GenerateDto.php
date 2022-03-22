<?php

namespace App\Console\Commands\GenerateModules;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class GenerateDto extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:dto';
    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     */
    protected static $defaultName = 'generate:dto';
    // protected $hidden = true;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Dto Module';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Dto';
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/dto.stub';
    }
    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $dto = class_basename($name);

        $replace = [
            '{{ dtoNamespace }}' => $this->rootNamespace() . 'Modules\\' . $dto,
            '{{ dto }}' => $dto
        ];

        return str_replace(
            array_keys($replace),
            array_values($replace),
            parent::buildClass($name)
        );
    }
    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = (string) Str::of($name)->replaceFirst($this->rootNamespace(), '');

        return $this->laravel->basePath('app/Modules/') . $name . '/' . $name . 'Dto.php';
    }
}
