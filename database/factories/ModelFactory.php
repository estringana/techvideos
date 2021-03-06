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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Label;
use App\Video;
use App\Vote;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Video::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->paragraphs(1, true),
        'speaker' => $faker->firstName . " ". $faker->lastName,
        'link' => $faker->url,
    ];
});

$factory->define(Label::class, function () {
    return [
        'name' => 'Label'.uniqid(),
    ];
});

$factory->define(Vote::class, function () {
    return [
        'vote' => (rand(0,10) % 2 == 0) ? Vote::VOTE_GOOD: Vote::VOTE_BAD
    ];
});
