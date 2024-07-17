<?php

namespace App\Domains\Login\Models;

use Illuminate\Database\Eloquent\Model;

class Franchises extends Model
{
        protected $fillable = [
            'id',
            'name',
            'domain',
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
