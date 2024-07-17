<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeDomainService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:domain-service {domain} {name} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service with in a specific domain';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $domain = $this->argument('domain');
    	$name = $this->argument('name');

    	$serviceName = ucfirst($name);
    	$directory = app_path('Domains/' . ucfirst($domain) . '/Services');

    	if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true, true);
    	}

    	$path = $directory . '/' . $serviceName . '.php';

    	if (File::exists($path)) {
            $this->error('Service already exists within the ' . $domain . ' domain.');
            return;
	}
        
        File::put($path, $this->serviceTemplate($serviceName, $domain));

        $this->info('Service created successfully within the ' . $domain . ' domain.'); 
    }
    protected function serviceTemplate($serviceName, $domain)
    {
        // You can customize the service template as needed
        return "<?php
            namespace App\Domains\\$domain\Services;

            use App\Domains\\$domain\Models\Product;
            class $serviceName implements ServiceInterface
            {

            }
        ";
    }
}
