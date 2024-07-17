<?php
 
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Domains\Login\Models\Users;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        DB::table('users')->insert([[
            'franchise_id' => null,
            'primary_provider_id' => null,
            'first_name' => 'test',
            'last_name' => 'test',
            'email' => 'testuser@gmail.com',
            'status' => 1,
            'created_by' => 1,
            'updated_by' => null,
            'updated_at' => null,
            'deleted_by' => null,
            'deleted_at' => null
        ],[
            'franchise_id' => 1,
            'primary_provider_id' => 1,
            'first_name' => 'test',
            'last_name' => 'test',
            'email' => 'providertest@gmail.com',
            'status' => 1,
            'created_by' => 1,
            'updated_by' => null,
            'updated_at' => null,
            'deleted_by' => null,
            'deleted_at' => null
        ]]);
    }
}