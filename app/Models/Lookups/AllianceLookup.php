<?php

namespace App\Models\Lookups;

use Illuminate\Database\Eloquent\Model;

class AllianceLookup extends Model
{
    //Table Name
    public $table = 'alliance_lookup';

    //Timestamps
    public $timestamps = false;

    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'alliance_id',
        'creator_corporation_id',
        'creator_id',
        'date_founded',
        'executor_corporation_id',
        'faction_id',
        'name',
        'ticker',
    ];

    
}