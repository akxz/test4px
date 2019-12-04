<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Section;
use Faker\Generator as Faker;

$factory->define(Section::class, function (Faker $faker) {
    $filePath = storage_path('app/logo');
    return [
        'name' => $faker->company,
        'description' => $faker->text(200),
        'logo' => $faker->image($filePath, 200, 200, null, false),
    ];
});
