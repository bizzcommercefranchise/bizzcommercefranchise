<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeDomainModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:domain-model {domain} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
      protected $description = 'Create a new model within a specific domain';
      
    /**
     * Execute the console command.
     */
    public function handle()
    {
    	$domain = $this->argument('domain');
    	$name = $this->argument('name');

    	$modelName = ucfirst($name);
    	$directory = app_path('Domains/' . ucfirst($domain) . '/Models');

    	if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }
        
        $path = $directory . '/' . $modelName . '.php';

        if (File::exists($path)) {
            $this->error('Model already exists within the ' . $domain . ' domain.');
            return;
    	}
        
        File::put($path, $this->modelTemplate($modelName, $domain));
        
        $this->info('Model created successfully within the ' . $domain . ' domain.');
        
        
        
    }
    
    protected function modelTemplate($modelName, $domain)
    {
        // You can customize the model template as needed
        return "<?php

                namespace App\Domains\\$domain\Models;

                use Illuminate\Database\Eloquent\Model;

                class $modelName extends Model
                {
                        protected \$fillable = [
                        // Define fillable attributes
                        ];

                        // Define relationships, scopes, etc.
                }
                ";
    }    
}
