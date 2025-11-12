<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory(1)->create([
            'email' => 'borygashill608@g.yju.ac.kr',
            'password' => bcrypt('asdf1234'),
        ]);

        User::factory(10)->create()->each(function ($user) {
            Post::factory(5)->create(['user_id' => $user->id]);
        });
    }
}
