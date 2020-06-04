<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\State;
use Faker\Generator as Faker;

$factory->define(State::class, function (Faker $faker) {
    $name = $faker->unique()->word;   
    return [
        'name'=> $name,
        'slug'=>$name,        
        'color'=> $faker->hexcolor
    ];
});
