<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'character_id',
        'permission',
    ];
    
    /**
     * Table Name
     */
    protected $table = 'user_permissions';
    
    public function user() {
        return $this->belongsTo(User::class);
    }
}