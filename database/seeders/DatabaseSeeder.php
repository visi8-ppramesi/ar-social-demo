<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\Group::create([
            'name'=>'public',
            'description'=>'public group'
        ]);

        \App\Models\Tag::create(['name' => 'Tag 1']);
        \App\Models\Tag::create(['name' => 'Tag 2']);
        \App\Models\Tag::create(['name' => 'Tag 3']);
        \App\Models\Tag::create(['name' => 'Tag 4']);

        \App\Models\User::create([
            'email' => 'ppramesi@visi8.com',
            'name' => 'ppramesi',
            'password' => Hash::make('123qweasd'),
        ]);
    }
}
