<?php

namespace App\Domains\Product\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
protected $fillable = [
        'id',
        'franchise_id',
        'provider_id',
        'name',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'        
];

// Define relationships, scopes, etc.
}
                