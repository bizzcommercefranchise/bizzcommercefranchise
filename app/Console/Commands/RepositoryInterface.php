<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RepositoryInterface extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repositoryinterface {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository interface';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');

    	$repositoryInterfaceName = ucfirst($name);
    	$directory = app_path('/Repositories');

    	if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }
        
        $path = $directory . '/' . $repositoryInterfaceName . '.php';
        
        if (File::exists($path)) {
            $this->error('Repository Interface already exists within the Repositories folder');
            return;
    	}
        
        File::put($path, $this->repositoryInterfaceTemplate($repositoryInterfaceName));
        
        $this->info('Repository Interface created successfully within the Repositories folder');
    }
    protected function repositoryInterfaceTemplate($repositoryInterfaceName)
    {
        // You can customize the repository template as needed
        return "<?php  
            namespace App\Repositories;
            
            interface RepositoryInterface
            {

            }
        ";
    }                
}
