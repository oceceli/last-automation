<?php

namespace App\Console\Commands;

use App\Console\Traits\Scaffolder;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateModelCommand extends Command
{
    use Scaffolder;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:model {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a model';
    

    protected $suffix = '';

    
    protected $sourceFile = 'model';


    protected $targetDirectory = "app/Models";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if($this->handler()) 
            $this->placeResourceRoute();
    }

    private function placeResourceRoute()
    {
        $source = file_get_contents('routes/web.php');

        $typo = 'Route::resource(\'/' . strtolower(Str::plural($this->argument('name'))) . '\', \'' . ucfirst($this->argument('name')) . 'Controller\');';
        // $typo = 'Route::resource(\'/' . strtolower($this->argument('name')) . 's' . '\', \'' . ucfirst($this->argument('name')) . 'Controller\');';

        $result = $this->insert($source, '#addAfter', "\t" . $typo);

        file_put_contents('routes/web.php', $result);
    }
}
