<?php

namespace App\Models\Lookups;

use Illuminate\Database\Eloquent\Model;

class CorporationLookup extends Model
{
    //Table Name
    public $table = 'corporation_lookup';

    //Timestamps
    public $timestamps = false;

    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'corporation_id',
        'alliance_id',
        'ceo_id',
        'creator_id',
        'date_founded',
        'description',
        'faction_id',
        'home_station_id',
        'member_count',
        'name',
        'shares',
        'tax_rate',
        'ticker',
        'url',
        'war_eligible',
    ];
}