<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->unsignedInteger('character_id')->unique();
                $table->string('avatar');
                $table->string('access_token')->nullable();
                $table->string('refresh_token')->nullable();
                $table->integer('inserted_at')->default(0);
                $table->integer('expires_in')->default(0);
                $table->string('owner_hash');
                $table->string('remember_token')->nullable();
                $table->string('user_type')->default('Guest');
                $table->timestamps();
            });
        }

        if(!Schema::hasTable('user_roles')) {
            Schema::create('user_roles', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('character_id');
                $table->foreign('character_id')->references('character_id')->on('users');
                $table->string('role')->default('None');
                $table->timestamps();
            });
        }

        if(!Schema::hasTable('esi_tokens')) {
            Schema::create('esi_tokens', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('character_id')->unique();
                $table->foreign('character_id')->references('character_id')->on('users');
                $table->string('access_token');
                $table->string('refresh_token');
                $table->integer('expires_in');
                $table->timestamps();
            });
        }

        if(!Schema::hasTable('esi_scopes')) {
            Schema::create('esi_scopes', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('character_id');
                $table->foreign('character_id')->references('character_id')->on('users');
                $table->string('scope');
                $table->timestamps();
            });
        }

        if(!Schema::hasTable('user_permissions')) {
            Schema::create('user_permissions', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('character_id');
                $table->foreign('character_id')->references('character_id')->on('users');
                $table->string('permission');
                $table->timestamps();
            });
        }

        if(!Schema::hasTable('available_user_permissions')) {
            Schema::create('available_user_permissions', function (Blueprint $table) {
                $table->increments('id');
                $table->string('permission');
            });
        }

        if(!Schema::hasTable('available_user_roles')) {
            Schema::create('available_user_roles', function (Blueprint $table) {
                $table->increments('id');
                $table->string('role');
                $table->string('description');
                $table->timestamps();
            });

            DB::table('available_user_roles')->insert([
                'role' => 'None',
                'description' => 'No roles whatsoever on the site.',
            ]);

            DB::table('available_user_roles')->insert([
                'role' => 'Guest',
                'description' => 'Guest of the site.',
            ]);

            DB::table('available_user_roles')->insert([
                'role' => 'User',
                'description' => 'User with non-admin access.',
            ]);

            DB::table('available_user_roles')->insert([
                'role' => 'Admin',
                'description' => 'User with admin access.',
            ]);

            DB::table('available_user_roles')->insert([
                'role' => 'SuperUser',
                'description' => 'SuperUser',
            ]);
        }

        if(!Schema::hasTable('allowed_logins')) {
            Schema::create('allowed_logins', function (Blueprint $table) {
                $table->increments('id');
                $table->string('entity_id');
                $table->string('entity_type');
                $table->string('entity_name');
                $table->string('login_type');
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_roles');
        Schema::dropIfExists('esi_tokens');
        Schema::dropIfExists('esi_scopes');
        Schema::dropIfExists('user_permissions');
        Schema::dropIfExists('available_user_permissions');
        Schema::dropIfExists('available_user_roles');
        Schema::dropIfExists('allowed_logins');
    }
}
