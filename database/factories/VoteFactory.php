<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Vote;
use App\Models\Post;
use App\Models\User;

class VoteFactory extends Factory
{
    protected $model = Vote::class;

    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id, // Random user
            'post_id' => Post::inRandomOrder()->first()->id, // Random post
            'vote_type' => $this->faker->randomElement(['upvote', 'downvote']),
        ];
    }
}
