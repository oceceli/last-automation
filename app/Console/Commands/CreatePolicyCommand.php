<?php

namespace App\Console\Commands;

use App\Console\Traits\Scaffolder;
use Illuminate\Console\Command;

class CreatePolicyCommand extends Command
{
    use Scaffolder;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:policy {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a policy';
    
    protected $sourceFile = 'Policy';

    protected $suffix = 'Policy';

    protected $targetDirectory = "app/Policies";

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
