<?php

namespace App\Models\Timer\Timer;

use Illuminate\Database\Eloquent\Model;

class Timer extends Model
{
    //Table Name
    protected $table = 'timers';

    //Primary Key
    public $primaryKey = 'id';

    //Timestamps
    public $timestamps = true;

    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'type',
        'stage',
        'region',
        'system',
        'planet',
        'moon',
        'owner',
        'eve_time',
        'notes',
        'user_id',
        'user_name',
    ];
}
