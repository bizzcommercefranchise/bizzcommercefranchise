<?php

namespace App\Domains\Login\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    protected $table = 'user_roles';
    protected $fillable = [
            'id',
            'user_id',
            'provider_id',
            'role_id',
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
                