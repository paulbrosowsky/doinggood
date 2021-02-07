<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategoriesSeeder::class,
            StatesSeeder::class,
            TagsSeeder::class,
            UsersSeeder::class,
            NeedsSeeder::class,            
        ]);
    }
}
