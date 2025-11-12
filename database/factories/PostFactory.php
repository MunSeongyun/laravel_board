<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function fakeHtml(){
        return '<p>' . fake()->paragraphs(3, true) . '</p>' . '<img src="' . 'https://kcenter.yju.ac.kr/api/20250326-085209_2a1d85e0-09d4-11f0-a48c-7979e565b199.png' . '" alt="Random Image">' . '<p>' . fake()->paragraphs(2, true) . '</p>';
    }

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'content' => $this->fakeHtml(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
