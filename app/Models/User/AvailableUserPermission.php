<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class AvailableUserPermission extends Model
{
    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'permission',
    ];

    protected $table = 'available_user_permissions';

    public $timestamps = false;
}