<?php
namespace App\Domains\Login\Models;

use Illuminate\Database\Eloquent\Model;

class Usercredentials extends Model
{
        protected $table = 'user_credentials';
        protected $fillable = [
            'id',
            'franchise_id',
            'user_id',
            'username',
            'password',
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
                