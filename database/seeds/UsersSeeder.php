<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UsersSeeder extends Seeder
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
        User::truncate();

        collect([
            [
                'id' => 1,
                'name' => 'Andreas Laschke',
                'username' => 'andreas_laschke',
                'email' => 'andreas@example.com',
                'helper' => true,
                'categories' => [2, 3]               
            ],
            [
                'id' => 2,
                'name' => 'Doing Good Challenge',
                'username' => 'doing_good_challenge',
                'email' => 'good@example.com', 
                'helper' => true,
                'categories' => [1]  
            ],
            [
                'id' => 3,
                'name' => 'Hieberschule Umwelt AG',
                'username' => 'hieberschule',
                'email' => 'schule@example.com',
                'helper' => false
            ],
            [
                'id' => 4,
                'name' => '3 Coole Typen',
                'username' => 'coole_typen',
                'email' => 'cool@example.com',
                'helper' => false 
            ],

            [
                'id' => 5,
                'name' => 'Bookworm AG',
                'username' => 'bookworm',
                'email' => 'bookworm@example.com',
                'helper' => false  
            ],


        ])->each(function($user){
            factory(User::class)->create([
                'name' => $user['name'],
                'username' => $user['username'],
                'email' => $user['email'],
                'helper' => $user['helper'],
                'password' => bcrypt('secret')
            ]);

            if($user['helper']){
                array_map(function($category) use ($user){
                    DB::table('categorizable')->insert([
                        'category_id' => $category,
                        'categorizable_id' => $user['id'],
                        'categorizable_type' => 'App\User'
                    ]);
                }, $user['categories']);
            }
        });
    }
}
