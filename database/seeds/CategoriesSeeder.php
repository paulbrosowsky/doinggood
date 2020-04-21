<?php

use App\Categorie;
use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $this->content();

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Seed the categories table.
     */
    protected function content()
    {
        Category::truncate();

        collect([
            [
                'name' => 'Geld',
                'slug' => 'geld',
                'icon' => '',
                'color' => '#f7a81b'
            ],
            [
                'name' => 'Sachen',
                'slug' => 'sachen',
                'icon' => '',
                'color' => '#019fcb'
            ],
            [
                'name' => 'Kompetenz',
                'slug' => 'kompetenz',
                'icon' => '',
                'color' => '#c10042'
            ]

        ])->each(function($category){
            factory(Category::class)->create([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'color' => $category['color'],
                'icon' => $category['icon'],
             ]);
        });
    }

}
