<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DDA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
//    protected $signature = 'app:d-d-a';
    protected $signature = 'domain:create {name : ExampleDomain}';

    /**
     * The console command description.
     *
     * @var string
     */
    //protected $description = 'Command description';
    protected $description = 'Create domain-driven architecture folder structure';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
    	$domainPath = app_path("Domains/{$name}");

    	$folders = [
        	'Exceptions',
        	'Http/Controllers',
        	'Http/Middleware',
        	'Http/Requests',
        	'Interfaces',
        	'Jobs',
        	'Models',
        	'Repositories',
        	'Resources/css',
        	'Resources/js',
        	'Resources/views',
        	'Routes',
        	'Services',
                'Rules',
                'Tests',               
    	];

    	// Create domain directory
    	if (!File::exists($domainPath)) {
            File::makeDirectory($domainPath, 0755, true);
    	}

    	// Create subdirectories
    	foreach ($folders as $folder) {
            File::makeDirectory("{$domainPath}/{$folder}", 0755, true);
    	}

    	$this->info("Domain structure for '{$name}' created successfully.");
    }
}

