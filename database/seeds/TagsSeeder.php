<?php

use Conner\Tagging\Model\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Tag::truncate();

        collect([
            'Kinder',
            'Senioren',
            'Schulgemeinschaft',
            'Jugendliche',
            'Geflüchtete',
            'Obdachlose',
            'Umwelt',
            'Natur',
            'Tiere',
            'Gesellschaft',
            'Entwicklungshilfe',
            'Integration'
        ])->each(function($tag){
            Tag::create([ 'name' => $tag ]);
        });

        Schema::enableForeignKeyConstraints();
    }
}
