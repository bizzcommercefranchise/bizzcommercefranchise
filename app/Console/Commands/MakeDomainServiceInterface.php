<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeDomainServiceInterface extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:domain-serviceinterface {domain} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service interface with in a specific domain';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $domain = $this->argument('domain');
    	$name = $this->argument('name');

    	$serviceInterfaceName = ucfirst($name);
    	$directory = app_path('Domains/' . ucfirst($domain) . '/Interfaces');

    	if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true, true);
    	}

    	$path = $directory . '/' . $serviceInterfaceName . '.php';

    	if (File::exists($path)) {
            $this->error('Service Interface already exists within the ' . $domain . ' domain.');
            return;
	}
        
        File::put($path, $this->serviceInterfaceTemplate($serviceInterfaceName, $domain));

        $this->info('Service Interface created successfully within the ' . $domain . ' domain.'); 
    }
    protected function serviceInterfaceTemplate($serviceInterfaceName, $domain)
    {
        // You can customize the service interface template as needed
        return "<?php
            namespace App\Domains\\$domain\Interfaces;

            interface $serviceInterfaceName
            {
                
            }
        ";
    }    
}
