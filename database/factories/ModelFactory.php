<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use Illuminate\Support\Facades\Hash;

$factory->define(Ahelos\User::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,
        'surname' => $faker->lastName,
        'company' => $faker->company,
        'company_id' => $faker->swiftBicNumber,
        'post' => $faker->postcode,
        'place' => $faker->country,
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'admin' => false,
        'password' => Hash::make('123456', ['rounds' => 15]),
        'remember_token' => str_random(10),
    ];
});
