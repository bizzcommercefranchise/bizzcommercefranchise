<?php
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Domains\Login\Models\Users;

class UserCredentailsSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        DB::table('user_credentials')->insert([[
            'id' => 1,
            'franchise_id' => null,
            'user_id' => 1,
            'username' => 'testuser@gmail.com',
            'password' => 'ceb6c970658f31504a901b89dcd3e461',
            'status' => 1,
            'created_by' => 1,
            'updated_by' => null,
            'updated_at' => null,
            'deleted_by' => null,
            'deleted_at' => null
        ],[
            'id' => 2,
            'franchise_id' => null,
            'user_id' => 14,
            'username' => 'admin@gmail.com',
            'password' => 'ceb6c970658f31504a901b89dcd3e461',
            'status' => 1,
            'created_by' => 1,
            'updated_by' => null,
            'updated_at' => null,
            'deleted_by' => null,
            'deleted_at' => null
        ],[
            'id' => 9,
            'franchise_id' => 1,
            'user_id' => 15,
            'username' => 'providertest@gmail.com',
            'password' => 'ceb6c970658f31504a901b89dcd3e461',
            'status' => 1,
            'created_by' => 1,
            'updated_by' => null,
            'updated_at' => null,
            'deleted_by' => null,
            'deleted_at' => null
        ]]);
    }
}