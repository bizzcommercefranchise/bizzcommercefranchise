<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProductCategoriesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('product_categories')->insert([[
            'franchise_id' => 1,
            'provider_id' => 5,
	    'name' => 'category name1',
            'status' => 1,
            'created_by' => 1,
            'updated_by' => null,
            'updated_at' => null,
            'deleted_by' => null,
            'deleted_at' => null
        ],[
  	    'franchise_id' => 1,
            'provider_id' => 5,
	    'name' => 'category name2',
            'status' => 1,
            'created_by' => 1,
            'updated_by' => null,
            'updated_at' => null,
            'deleted_by' => null,
            'deleted_at' => null
        ],[
  	    'franchise_id' => 1,
            'provider_id' => 5,
	    'name' => 'category name3',
            'status' => 1,
            'created_by' => 1,
            'updated_by' => null,
            'updated_at' => null,
            'deleted_by' => null,
            'deleted_at' => null
        ]]);
    }
}

