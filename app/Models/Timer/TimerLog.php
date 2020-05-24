<?php

namespace App\Models\Timer\Log;

use Illuminate\Database\Eloquent\Model;

class TimerLog extends Model
{
    //Table Name
    protected $table = 'logs';

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
        'user_id',
        'user',
        'entry',
    ];
}
