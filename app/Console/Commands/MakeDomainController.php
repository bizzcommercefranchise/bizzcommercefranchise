<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeDomainController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //protected $signature = 'app:make-domain-controller';
    protected $signature = 'make:domain-controller {domain} {name}';


    /**
     * The console command description.
     *
     * @var string
     */
    //protected $description = 'Command description';
    protected $description = 'Create a new controller within a specific domain';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $domain = $this->argument('domain');
    	$name = $this->argument('name');

    	$controllerName = ucfirst($name);
    	$directory = app_path('Domains/' . ucfirst($domain) . '/Http/Controllers');

    	if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true, true);
    	}

    	$path = $directory . '/' . $controllerName . '.php';

    	if (File::exists($path)) {
            $this->error('Controller already exists within the ' . $domain . ' domain.');
            return;
	}
        
        File::put($path, $this->controllerTemplate($controllerName, $domain));

        $this->info('Controller created successfully within the ' . $domain . ' domain.');        
    }
    
    protected function controllerTemplate($controllerName, $domain)
    {
        // You can customize the controller template as needed
        return "<?php

            namespace App\Domains\\$domain\Http\Controllers;

            use App\Http\Controllers\Controller;
            use Illuminate\Http\Request;
            use App\Domains\Product\Interfaces\ProductServiceInterface;

            class $controllerName extends Controller
            {
                    //
            }
            ";
    }
}
