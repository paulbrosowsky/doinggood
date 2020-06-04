<?php

use App\Category;
use App\Need;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class NeedsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        Need::truncate();

        // factory(Need::class, 100)->create();

        factory(Need::class, 100)->state('from_existing_data')->create()->each(function($need){
            DB::table('categorizables')->insert([
                'category_id' => Category::all()->random()->id,
                'categorizable_id' => $need->id,
                'categorizable_type' => 'App\Need'
            ]);           
        });

        Schema::enableForeignKeyConstraints();
    }
}
