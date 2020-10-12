<?php

namespace App\Console\Commands;

// use App\Traits\GlobalHelpers;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateAllCommand extends Command
{
    // use GlobalHelpers;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:all {name?} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create contract, repository, controller, policy, resource and Test';


    /**
     * create:'command'
     * Sadece name beklentileri var. Controllerı ayrı tuttum iki attribute bekliyor. manuel girdim. 
     */
    protected $commands = [
        'model', 'contract', 'repository', 'policy', 'controller', 
    ];


    /**
     * Execute the console command.
     * create:all {name} name verildi ise hepsini oluşturur. Verilmediyse tek tek sorar
     *
     * @return mixed
     */
    public function handle()
    {
        if($this->argument('password') == 'ekmek') { // :))
            if($this->argument('name')) {
                $this->createOnce();
            } else {
                $this->createOneByOne();
            }
        } else {
            $this->alert('Şifre gerekli!');
        }
        
    }


    private function createOnce() 
    {
        foreach ($this->commands as $command) {
            $this->call('create:' . $command, ['name' => $this->argument('name')]);
        }
        // ayrıyeten... laravelin kendi komutları
        $this->call('make:factory', ['name' => ucfirst($this->argument('name')) . 'Factory', '--model' => ucfirst($this->argument('name'))]);
        $this->call('make:migration',  ['name' => 'create_' . strtolower(Str::plural($this->argument('name'))) . '_table']);

        $this->alert('İşlem tamamlandı, lütfen ilgili migration ve factory dosyalarını düzenleyin...');
    }


    private function createOneByOne()
    {
        foreach ($this->commands as $command) {
            $answer = ucfirst($this->ask(ucfirst($command) . " adını giriniz"));
            if ($answer != null && !is_numeric($answer)) {
                $this->call('create:' . $command, ['name' => $answer]);
            } else $this->warn(ucfirst($command) . " oluşturulmadı..");
        }
    }
}
