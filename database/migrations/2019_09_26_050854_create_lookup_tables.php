<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLookupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('character_lookup')) {
            Schema::create('character_lookup', function (Blueprint $table) {
                $table->unsignedInteger('character_id');
                $table->unsignedInteger('alliance_id');
                $table->unsignedInteger('ancestry_id')->nullable();
                $table->string('birthday');
                $table->unsignedInteger('bloodline_id');
                $table->unsignedInteger('corporation_id');
                $table->string('description')->nullable();
                $table->unsignedInteger('faction_id')->nullable();
                $table->string('gender');
                $table->string('name');
                $table->unsignedInteger('race_id');
                $table->float('security_status');
                $table->string('title');
            });
        }
        
        if(!Schema::hasTable('corporation_lookup')) {
            Schema::create('corporation_lookup', function (Blueprint $table) {
                $table->unsignedInteger('corporation_id');
                $table->unsignedInteger('alliance_id')->nullable();
                $table->unsignedInteger('ceo_id');
                $table->unsignedInteger('creator_id');
                $table->string('date_founded')->nullable();
                $table->string('description')->nullable();
                $table->unsignedInteger('faction_id')->nullable();
                $table->unsignedInteger('home_station_id')->nullable();
                $table->unsignedInteger('member_count');
                $table->string('name');
                $table->unsignedInteger('shares')->nullable();
                $table->decimal('tax_rate', 20, 2);
                $table->string('ticker');
                $table->string('url')->nullable();
                $table->boolean('war_eligible');
            });
        }
    
        if(!Schema::hasTable('alliance_lookup')) {
            Schema::create('alliance_lookup', function (Blueprint $table) {
                $table->unsignedInteger('alliance_id');
                $table->unsignedInteger('creator_corporation_id');
                $table->unsignedInteger('creator_id');
                $table->dateTime('date_founded');
                $table->unsignedInteger('executor_corporation_id')->nullable();
                $table->unsignedInteger('faction_id')->nullable();
                $table->string('name');
                $table->string('ticker');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('character_lookup');
        Schema::dropIfExists('corporation_lookup');
        Schema::dropIfExists('alliance_lookup');
    }
}