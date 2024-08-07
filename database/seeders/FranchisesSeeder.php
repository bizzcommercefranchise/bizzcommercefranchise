<?php
 
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Domains\Login\Models\Users;

class FranchisesSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        DB::table('franchises')->insert([[
            'name' => 'KFC',
            'domain' => 'Fast Food Industry',
            'status' => 1,
            'created_by' => 1,
            'updated_by' => null,
            'updated_at' => null,
            'deleted_by' => null,
            'deleted_at' => null
        ],[
            'name' => "McDonald's",
            'domain' => 'Fast Food Industry',
            'status' => 1,
            'created_by' => 1,
            'updated_by' => null,
            'updated_at' => null,
            'deleted_by' => null,
            'deleted_at' => null
        ]]);
    }
}