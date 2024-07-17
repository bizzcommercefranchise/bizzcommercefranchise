<?php

namespace App\Domains\Provider\Models;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
        protected $fillable = [
            'id',
            'name',
            'address',
            'city',
            'state',
            'country',
            'postal_code',
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
                