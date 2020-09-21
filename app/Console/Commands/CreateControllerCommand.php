<?php

namespace App\Console\Commands;

use App\Console\Traits\Scaffolder;
use Illuminate\Console\Command;

class CreateControllerCommand extends Command
{
    use Scaffolder;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:controller {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a controller';
    

    protected $suffix = 'Controller';


    protected $targetDirectory = "app/Http/Controllers";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        return $this->handler();
    }
}
