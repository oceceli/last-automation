<?php

namespace App\Console\Traits;

// use App\Traits\GlobalHelpers;
use Illuminate\Support\Facades\Storage;


trait Scaffolder
{
    // use GlobalHelpers;

    protected $stubsPath = 'stubs/';


    /**
     * Handler method
     * @return void
     */
    protected function handler()
    {
        $draft = $this->source();
        foreach ($this->args() as $arg) {
            $draft = str_replace('$' . $arg, ucfirst($this->argument($arg)), $draft);
        }
        $this->writeFile($draft);
        return true;
    }



    /**
     * The motor function that write given data to target
     * @return void
     */
    protected function writeFile($data): void
    {
        if ( ! file_exists($this->target())) {
            file_put_contents($this->target(), $data);
            $this->info($this->fileName() . " başarıyla oluşturuldu!");
        } else {
            $this->warn($this->target() . " dosyas? zaten var!");
        }
    }


    /**
     * Stub files to use
     * @return string
     */
    protected function source(): string
    {
        $sourceFile = $this->suffix == '' ? $this->sourceFile : $this->suffix;
        return Storage::get($this->stubsPath . strtolower($sourceFile));
    }


    /**
     * Target directory to put changes
     * @return $string
     */
    protected function target(): string
    {
        return $this->targetDirectory . "/" . $this->fileName();
    }

    /**
     * Sets the file name
     * @return string
     */
    protected function fileName()
    {
        return ucfirst($this->argument($this->args()[0])) . $this->suffix . ".php"; // args()[0] will be assumed as name of the class.
    }


    /**
     * Get argument names
     * Shifting necessary because first one is command name.
     * @return array
     */
    protected function args()
    {
        $args = array_keys($this->arguments());
        array_shift($args);
        return $args;
    }

}
