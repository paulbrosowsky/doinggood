<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'user_id'=> function(){
            return factory('App\User')->create()->id;
        }, 
        'help_id'=> function(){
            return factory('App\Help')->create()->id;
        }, 
        'body' => $faker->paragraph()
    ];
});
