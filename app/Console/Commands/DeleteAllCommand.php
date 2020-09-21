<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteAllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:all {name} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete contract, repository, controller, policy, resource, factory and test according to given name';



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


    protected $routes = [
        'api' => 'routes/api.php',
        'web' => 'routes/web.php',
    ];

    protected $repositorySP = 'app/Providers/RepositoryServiceProvider.php';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->argument('password') === 'ekmek' && $this->argument('password') != '') {
            if ($name = $this->argument('name')) {
                $this->destroyer(ucfirst($name));
                $this->cleaner(ucfirst($name));
            } else {
                $this->error(PHP_EOL . "'name' belirtilmelidir!");
            }
        } else {
            $this->alert('Bunu yapmak için bir şifre gerekli!');
        }
    }



    private function destroyer($name)
    {
        foreach ($this->prefixSuffix as $ps) {
            if ($file = $ps['prefix'] . $name . $ps['suffix'] . '.php') {
                if ($this->confirm($file . ' silinecek. Emin misin?')) {
                    $this->sendTrash($file);
                } else {
                    $this->warn($name . $ps['suffix'] . ' pas geçiliyor...');
                }
            } else {
                $this->warn('Belirtilen dosya yok ya da zaten silinmiş!');
            }
        }
    }



    private function cleaner($name)
    {
        if ($this->confirm($name . " için rotalardaki girdiler de temizlensin mi?")) {
            if ($this->removeRouteEntries($name))
                $this->comment('Rotalar temizlendi!');
        } else $this->warn('Rotalar pas geçiliyor...' . PHP_EOL);

        if ($this->confirm($name . " için RepositoryServiceProvider girdileri de silinsin mi?")) {
            if ($this->removeServiceEntries($name))
                $this->comment('İlgili RepositoryServiceProvider girdileri kaldırıldı!' . PHP_EOL);
        } else $this->warn('RepositoryServiceProvider girdileri pas geçiliyor...' . PHP_EOL);
    }





    // Motor functions --------------------------- 

    private function sendTrash($source)
    {
        $target = 'trash/' . pathinfo($source)['dirname'];
        if (file_exists($source)) {
            if (!file_exists($target)) {
                mkdir($target, 0755, true);
            }
            rename($source, 'trash/' . $source . '.trashed'); // move
            $this->info($source . ' silindi!');
        } else {
            $this->warn($source . " bulunamadı!");
        }
    }


    private function removeRouteEntries($name)
    {
        $pattern = '/Route::.*?\/?' . strtolower($this->makePlural($name)) . '.*?,.*' . ucfirst($name) . '.*?;/';

        foreach ($this->routes as $route) {
            $source = file_get_contents($route);
            $result = $this->findAllAndReplace($pattern, '', $source);
            file_put_contents($route, $result);
        }
        return true;
    }


    private function removeServiceEntries($name)
    {
        $pattern = '/\$this->app->bind\(\'App\\\Contracts\\\\' . ucfirst($name) . 'Contract.*' . ucfirst($name) . 'Repository.*?;/';

        $source = file_get_contents($this->repositorySP);
        $result = $this->findAllAndReplace($pattern, '', $source);
        file_put_contents($this->repositorySP, $result);
        return true;
    }
}
