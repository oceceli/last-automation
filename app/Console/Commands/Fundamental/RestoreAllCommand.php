<?php

namespace App\Console\Commands\Fundamental;

use Illuminate\Console\Command;

class RestoreAllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'restore:all {class} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore deleted classes';


    protected $prefixSuffix = [
        ['prefix' => 'app/Models', 'suffix' => ''],
        ['prefix' => 'app/Http/Controllers/', 'suffix' => 'Controller'],
        ['prefix' => 'app/Contracts/', 'suffix' => 'Contract'],
        ['prefix' => 'app/Repositories/', 'suffix' => 'Repository'],
        ['prefix' => 'app/Policies/', 'suffix' => 'Policy'],
        ['prefix' => 'app/Http/Resources/', 'suffix' => 'Resource'],
        ['prefix' => 'tests/Feature/', 'suffix' => 'Test'],
        ['prefix' => 'database/factories/', 'suffix' => 'Factory'],
    ];


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->argument('password') === 'ekmek' && $this->argument('password') != '') {
            $name = ucfirst($this->argument('class'));
            $this->restoreOnce($name);
            exit;
        } else {
            $this->alert('Bunu yapmak için bir şifre gerekli!');
        }
    }


    private function restoreOnce($name)
    {
        foreach($this->prefixSuffix as $ps) {
            $file = $ps['prefix'] . $name . $ps['suffix'] . '.php';
            $trashFile = 'trash/' . $file . '.trashed';
            if(file_exists($trashFile)) {
                if( ! file_exists($file)) { 
                    rename($trashFile, $file);
                    $this->info(pathinfo($file)['filename'] . ' restorasyonu başarılı oldu!');
                } else { // çöpte değil de kendi yerindeyse
                    $this->warn(pathinfo($file)['filename'] . ' ' . pathinfo($file)['dirname'] . ' içerisinde' . " zaten var!");
                }
            } else {
                $this->warn($name . $ps['suffix'] . " çöpte değil!");
            }
        }
    }


    private function oneByOne()
    {
        
    }

}
