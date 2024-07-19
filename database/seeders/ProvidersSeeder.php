<?php
 
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Domains\Login\Models\Users;

class ProvidersSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        DB::table('providers')->insert([[
            'franchise_id' => 1,
            'name' => 'KFC Hyderabad',
            'email' => 'kfchyd@gmail.com',
            'status' => 1,
            'created_by' => 1,
            'updated_by' => null,
            'updated_at' => null,
            'deleted_by' => null,
            'deleted_at' => null
        ],[
            'franchise_id' => 1,
            'name' => 'KFC Chennai',
            'email' => 'kfcchennai@gmail.com',
            'status' => 1,
            'created_by' => 1,
            'updated_by' => null,
            'updated_at' => null,
            'deleted_by' => null,
            'deleted_at' => null
        ],[
            'franchise_id' => 2,
            'name' => "McDonald's Hyderabad",
            'email' => 'mcdonaldshyd@gmail.com',
            'status' => 1,
            'created_by' => 1,
            'updated_by' => null,
            'updated_at' => null,
            'deleted_by' => null,
            'deleted_at' => null
        ],[
            'franchise_id' => 2,
            'name' => "McDonald's Chennai",
            'email' => 'mcdonaldschennai@gmail.com',
            'status' => 1,
            'created_by' => 1,
            'updated_by' => null,
            'updated_at' => null,
            'deleted_by' => null,
            'deleted_at' => null
        ]]);
    }
}