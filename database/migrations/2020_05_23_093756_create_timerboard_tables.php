<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimerboardTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('timers')) {
            Schema::create('timers', function(Blueprint $table) {
                $table->unsignedBigIncrements('id');
                $table->string('type');
                $table->string('stage');
                $table->string('region');
                $table->string('system');
                $table->string('planet')->nullable();
                $table->string('moon')->nullable();
                $table->string('owner');
                $table->dateTime('eve_time');
                $table->text('notes');
                $table->unsignedBigInteger('user_id');
                $table->string('user_name');
            });
        }

        if(!Schema::hasTable('logs')) {
            Schema::create('logs', function(Blueprint $table) {
                $table->unsignedBigIncrements('id');
                $table->unsignedBigInteger('user_id');
                $table->string('user');
                $table->text('entry');
                $table->timestamps();
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
        Schema::dropIfExists('timers');
        Schema::dropIfExists('logs');
    }
}
