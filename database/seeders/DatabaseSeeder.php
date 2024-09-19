<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        \App\Models\User::factory(10)->create();   // Membuat 10 user
        \App\Models\Post::factory(20)->create();   // Membuat 20 post
        \App\Models\Comment::factory(50)->create(); // Membuat 50 comment
        \App\Models\Vote::factory(100)->create();  // Membuat 100 vote
    }
}
