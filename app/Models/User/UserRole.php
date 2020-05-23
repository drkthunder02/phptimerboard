<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    /**
     * Table Name
     */
    protected $table = 'user_roles';
 
    /**
     * Mass assignable items
     * 
     * @var array
     */
    protected $fillable = [
        'character_id',
        'role',
    ];
 
    public function user() {
        return $this->belongsTo(User::class);
    }
}