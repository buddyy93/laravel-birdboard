<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'title'       => $faker->sentence,
        'description' => $faker->sentence,
        'notes'       => $faker->paragraph,
        'owner_id'    => factory(\App\User::class)
    ];
});