<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents; // Post Factory가 rich_texts 테이블에 데이터를 저장하게 할 수 있도록
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Comment;

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
            'login_id' => 'jia3',
            'email' => 'jia3@g.yju.ac.kr',
            'password' => bcrypt('jittest'),
        ]);

        User::factory(10)->create()->each(function ($user) {
            Post::factory(50)->create(['user_id' => $user->id])->each(function ($post) {
                // 각 포스트에 대해 0~5개의 댓글 생성
                $commentsCount = rand(0, 5);
                Comment::factory($commentsCount)->create([
                    'post_id' => $post->id,
                    'user_id' => User::inRandomOrder()->first()->id, // 댓글 작성자를 랜덤으로 선택
                ]);
            });
        });
    }
}
