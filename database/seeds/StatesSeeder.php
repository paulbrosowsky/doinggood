<?php

use App\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        State::truncate();

        collect([
            [
                'name' => 'offen',
                'slug' => 'offen',               
                'color' => '#eeeee',                
            ],
            [
                'name' => 'vermittelt',
                'slug' => 'vermittelt',               
                'color' => '#019fcb',                
            ],
            [
                'name' => 'abgeschlossen',
                'slug' => 'abgeschlossen',                               
                'color' => '#f7a81b',  
            ]

        ])->each(function($category){
            factory(State::class)->create([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'color' => $category['color'],               
             ]);
        });

        Schema::enableForeignKeyConstraints();
    }
}
