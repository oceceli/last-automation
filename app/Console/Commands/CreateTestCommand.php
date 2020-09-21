<?php

namespace App\Console\Commands;

use App\Console\Traits\Scaffolder;
use Illuminate\Console\Command;

class CreateTestCommand extends Command
{

    use Scaffolder;


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:test {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a test';

    
    protected $suffix = 'Test';


    protected $targetDirectory = "tests/Feature";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $draft = $this->source();
                
        $result = str_replace(['$name', '$lowerName'], [$this->argument('name'), strtolower($this->argument('name'))], $draft);
        $this->writeFile($result);

    }

    /**
     * The motor function that writes given data to target
     * @return void
     */
    protected function writeFile($data): void
    {
        if (!file_exists($this->target())) {
            file_put_contents($this->target(), $data);
            $this->info($this->fileName() . " baÅŸarÄ±yla oluÅŸturuldu!");
        } else $this->warn($this->target() . " dosyası zaten var!");
    }


    
}
