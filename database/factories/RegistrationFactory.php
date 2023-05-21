<?php
use App\Models\Registration;
use Faker\Generator as Faker;

$factory->define(Registration::class, function (Faker $faker) {
    return [
        'event' => $faker->numberBetween(1, 5),
        'startDate' => $faker->date(),
        'endDate' => $faker->date(),
        'name' => $faker->name,
        'cpf' => $faker->numerify('###########'),
        'email' => $faker->email,
    ];
});
