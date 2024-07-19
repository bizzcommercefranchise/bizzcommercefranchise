<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeTests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:test {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a tests file in tests folder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
    	$name = $this->argument('name');

    	$testsName = ucfirst($name);
    	$directory = base_path('/tests/Feature');
    	if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }
        
        $path = $directory . '/' . $testsName . '.php';

        if (File::exists($path)) {
            $this->error('Tests file already exists within the tests folder.');
            return;
    	}
        
        File::put($path, $this->testsTemplate($testsName));
        
        $this->info('Tests file created successfully within the tests folder');
    }
    protected function testsTemplate($testsName)
    {
        // You can customize the tests template as needed
        return "<?php

            namespace App\Tests\Feature;

            use App\Http\Controllers\Controller;
            use Illuminate\Http\Request;
            use App\Domains\Product\Interfaces\ProductServiceInterface;

            class $testsName extends TestCase
            {
                //
            }
            ";       
    }
    
}
