<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('products')->insert([[
            'franchise_id' => 1,
            'provider_id' => 5,
	    'product_category_id' => 4,
	    'name' => 'product1',
	    'cost' => 1.00,
            'status' => 1,
            'created_by' => 1,
            'updated_by' => null,
            'updated_at' => null,
            'deleted_by' => null,
            'deleted_at' => null
        ],[
            'franchise_id' => 1,
            'provider_id' => 5,
	    'product_category_id' => 5,
	    'name' => 'product2',
	    'cost' => 2.00,
            'status' => 1,
            'created_by' => 1,
            'updated_by' => null,
            'updated_at' => null,
            'deleted_by' => null,
            'deleted_at' => null
        ],[
            'franchise_id' => 1,
            'provider_id' => 5,
	    'product_category_id' => 6,
	    'name' => 'product3',
	    'cost' => 3.00,
            'status' => 1,
            'created_by' => 1,
            'updated_by' => null,
            'updated_at' => null,
            'deleted_by' => null,
            'deleted_at' => null
        ]]);
    }
}

