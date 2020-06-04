<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Help;

use Faker\Generator as Faker;

$factory->define(Help::class, function (Faker $faker) {
    return [
        'user_id'=> function(){
            return factory('App\User')->create()->id;
        }, 
        'need_id'=> function(){
            return factory('App\Need')->create()->id;
        }, 
        'state_id'=> function(){
            return factory('App\State')->create()->id;
        },
    ];
});
