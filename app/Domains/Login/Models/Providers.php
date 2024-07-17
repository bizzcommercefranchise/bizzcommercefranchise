<?php

namespace App\Domains\Login\Models;

use Illuminate\Database\Eloquent\Model;

class Providers extends Model
{
        protected $fillable = [
            'id',
            'franchise_id',
            'name',
            'location_id',
            'email',
            'status',
            'created_by',
            'created_at',
            'updated_by',
            'updated_at',
            'deleted_by',
            'deleted_at',
            'location_id'
        ];

        // Define relationships, scopes, etc.
}
                