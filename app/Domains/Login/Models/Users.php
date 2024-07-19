<?php

namespace App\Domains\Login\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';
    protected $fillable = [
            'id',
            'franchise_id',
            'primary_provider_id',
            'first_name',
            'last_name',
            'email',
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
                