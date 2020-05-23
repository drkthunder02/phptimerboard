<?php

namespace App\Models\Lookups;

use Illuminate\Database\Eloquent\Model;

class CharacterLookup extends Model
{
    //Table Name
    public $table = 'character_lookup';

    //Timestamps
    public $timestamps = false;

    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'character_id',
        'alliance_id',
        'ancestry_id',
        'birthday',
        'bloodline_id',
        'corporation_id',
        'description',
        'faction_id',
        'gender',
        'name',
        'race_id',
        'security_status',
        'title',
    ];
}