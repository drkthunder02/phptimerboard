<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User\User::class, function (Faker $faker) {
    return [
        'name' => 'A Name',
        'character_id' => 0000000,
        'avatar' => 'https://images.eveonline.com',
        'access_token' => '',
        'refresh_token' => '',
        'inserted_at' => 0,
        'expires_in' => 0,
        'owner_has' => 'some hash',
        'remember_token' => '',
        'user_type' => 'Guest',
    ];
});

?>