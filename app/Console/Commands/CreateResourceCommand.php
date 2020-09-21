<?php

namespace App\Console\Commands;

use App\Console\Traits\Scaffolder;
use Illuminate\Console\Command;

class CreateResourceCommand extends Command
{
    use Scaffolder;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:resource {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a resource';


    protected $suffix = '';


    protected $sourceFile = 'Resource';


    protected $targetDirectory = "app/Http/Resources";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->handler();
    }
}
