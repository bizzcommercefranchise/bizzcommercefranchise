<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Repository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');

    	$repositoryName = ucfirst($name);
    	$directory = app_path('/Repositories');

    	if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }
        
        $path = $directory . '/' . $repositoryName . '.php';
        
        if (File::exists($path)) {
            $this->error('Repository already exists within the Repositories folder');
            return;
    	}
        
        File::put($path, $this->repositoryTemplate($repositoryName));
        
        $this->info('Repository created successfully within the Repositories folder');
    }
    protected function repositoryTemplate($repositoryName)
    {
        // You can customize the repository template as needed
        return "<?php

            namespace App\Repositories;

            use Illuminate\Database\Eloquent\Model;
            use Illuminate\Support\Facades\DB;
            
            class $repositoryName implements RepositoryInterface
            {
                    //
            }
            ";
    }    
}
