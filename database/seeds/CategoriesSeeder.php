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
                'icon' => '<svg class="h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M234 272v-48h131.094l7.149-48H234v-1.83c0-35.92 14.975-58.086 79.25-58.086 26.264 0 55.867 2.498 93.189 8.742L416 59.866C377.988 51.123 345.306 48 310.057 48 195.326 48 146 89.225 146 165.43V176H96v48h50v48H96v48h50v26.57C146 422.774 195.297 464 310.027 464c35.25 0 67.848-3.123 105.859-11.866l-9.619-64.96c-37.322 6.244-66.781 8.742-93.045 8.742-64.276 0-79.223-18.739-79.223-63.086V320h116.795l7.148-48H234z"/></svg>',
                'color' => '#f7a81b'
            ],
            [
                'name' => 'Sachen',
                'slug' => 'sachen',
                'icon' => '<svg class="h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M424 134.5h-45.8c2.3-6.6 3.8-13.9 3.8-21.3 0-35.4-28.1-63.2-63-63.2-22.1 0-41.2 10.7-52.5 28L256 92.3l-10.5-14.5C234.2 60.7 215.1 48 193 48c-34.9 0-63 29.8-63 65.2 0 7.5 1.5 14.7 3.8 21.3H88c-23.3 0-41.8 19-41.8 42.7L46 421.8c0 23.7 17.4 42.2 40.7 42.2h336.7c23.3 0 42.7-18.5 42.7-42.2V177.2c-.1-23.7-18.8-42.7-42.1-42.7zM320 91c11.6 0 21 9.5 21 21 0 11.6-9.4 21-21 21s-21-9.5-21-21 9.4-21 21-21zm-128 0c11.6 0 21 9.5 21 21 0 11.6-9.4 21-21 21s-21-9.5-21-21 9.4-21 21-21zM88 177.2h106.7L151 237.5l34 25 50-69.1.2-.2-.2 228.6H88V177.2zm336 244.6H277V193.4l50 69.1 34-25-43.7-60.4H424v244.7z"/></svg>',
                'color' => '#019fcb'
            ],
            [
                'name' => 'Kompetenz',
                'slug' => 'kompetenz',
                'icon' => '<svg class="h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M304 256c52.805 0 96-43.201 96-96s-43.195-96-96-96-96 43.201-96 96 43.195 96 96 96zm0 48c-63.598 0-192 32.402-192 96v48h384v-48c0-63.598-128.402-96-192-96zM112 224v-64H80v64H16v32h64v64h32v-64h64v-32h-64z"/></svg>',
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
