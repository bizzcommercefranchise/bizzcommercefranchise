<?php

namespace App\Domains\Provider\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderUsers extends Model
{
        protected $fillable = [
            'id',
            'user_id',
            'provider_id',
            'name',
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
                