<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeDomainRule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:domain-rule {domain} {name}';    
//    protected $signature = 'app:make-domain-rule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new rule within a specific domain';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $domain = $this->argument('domain');
    	$name = $this->argument('name');

    	$ruleName = ucfirst($name);
    	$directory = app_path('Domain/' . ucfirst($domain) . '/Rules');

    	if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }
        
        $path = $directory . '/' . $ruleName . '.php';

        if (File::exists($path)) {
            $this->error('Rule already exists within the ' . $domain . ' domain.');
            return;
    	}
        
        File::put($path, $this->ruleTemplate($ruleName, $domain));
        
        $this->info('Rule created successfully within the ' . $domain . ' domain.');
    }
    
    protected function ruleTemplate($ruleName, $domain)
    {
        // You can customize the rule template as needed
        return "<?php

                namespace App\Domain\\$domain\Rules;
                namespace App\Domain\ExampleDomain\Models;
                use Illuminate\Database\Eloquent\Model;
                class $ruleName 
                {
                        //
                }
                ";
    }
    
}
