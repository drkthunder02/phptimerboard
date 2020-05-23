<?php

namespace App\Models\Esi;

use Illuminate\Database\Eloquent\Model;

class EsiToken extends Model
{
    // Table Name
    protected $table = 'esi_tokens';

    //Primary Key
    public $primaryKey = 'id';

    // Timestamps
    public $timestamps = true;

    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'character_id',
        'access_token',
        'refresh_token',
        'expires_in',
    ];
    public function esiscopes() {
        return $this->hasMany('App\Models\EsiScope', 'character_id', 'character_id');
    }
}