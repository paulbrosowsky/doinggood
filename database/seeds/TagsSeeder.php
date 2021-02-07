<?php

use Conner\Tagging\Model\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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

        $tags = collect([
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
        ]);
        $tags->each(function($tag){
            $tag = Conner\Tagging\Model\Tag::create([ 'name' => $tag ]);
            Illuminate\Support\Facades\DB::table('tagging_tagged')->insert([
                'taggable_id' => 9999999,
                'taggable_type' => 'App\Need',
                'tag_name' => $tag->name,
                'tag_slug' => $tag->slug 
            ]);
        });

        Schema::enableForeignKeyConstraints();
    }
}
