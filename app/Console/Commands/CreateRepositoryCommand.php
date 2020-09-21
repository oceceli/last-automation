<?php

namespace App\Console\Commands;

use App\Console\Traits\Scaffolder;
use Illuminate\Console\Command;

class CreateRepositoryCommand extends Command
{
    use Scaffolder;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a repository';
    

    protected $suffix = 'Repository';


    protected $targetDirectory = "app/Repositories";


    

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if($this->handler()) {
            $this->writeRepositoryServiceProvider();
        }

    }

    private function writeRepositoryServiceProvider()
    {
        $source = file_get_contents('app/Providers/RepositoryServiceProvider.php');

        $typo = '$this->app->bind(' . '\'App\Contracts\\' . ucfirst($this->argument('name')) . 'Contract\', \'App\Repositories\\' . ucfirst($this->argument('name')) . 'Repository\'' . ');';

        $result = $this->insert($source, '#addAfter', "\t\t" . $typo);

        file_put_contents('app/Providers/RepositoryServiceProvider.php', $result);
    }

    



    
}
