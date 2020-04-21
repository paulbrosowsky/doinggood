<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Need;
use Faker\Generator as Faker;

$factory->define(Need::class, function (Faker $faker) {
    return [
        'user_id'=> function(){
            return factory('App\User')->create()->id;
        },        
        'title' => $faker->sentence,
        'project_description' => $faker->paragraph(2),
        'need_description' => $faker->paragraph(5),
        'deadline' => now()->addWeek(),
    ];
});

$factory->state(Need::class, 'from_existing_data', function(Faker $faker){    
    return [
        'user_id'=> function(){
            return \App\User::all()->random()->id;
        }, 
        'title' => $faker->sentence,
        'project_description' => $faker->paragraph(2),
        'need_description' => $faker->paragraph(5),
        'deadline' => now()->addWeek(), 
    ];

});
