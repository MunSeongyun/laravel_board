<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents; // Post Factory가 rich_texts 테이블에 데이터를 저장하게 할 수 있도록
use Illuminate\Database\Seeder;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    // use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory(1)->create([
            'name' => 'Test Admin',
            'email' => 'testadmin@g.yju.ac.kr',
            'password' => bcrypt('asdf1234'),
        ]);

        User::factory(10)->create()->each(function ($user) {
            Post::factory(500)->create(['user_id' => $user->id]);
        });
    }
}
