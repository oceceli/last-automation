<?php

namespace App\Console\Commands;

use App\Console\Traits\Scaffolder;
use Illuminate\Console\Command;

class CreateContractCommand extends Command
{

    use Scaffolder;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:contract {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a Contract';
    

    protected $suffix = 'Contract';


    protected $targetDirectory = "app/Contracts";

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
