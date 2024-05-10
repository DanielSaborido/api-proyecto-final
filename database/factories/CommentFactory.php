<?php

namespace Database\Factories;

use App\Models\CommentAndRating;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentAndRatingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CommentAndRating::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => $this->faker->numberBetween(1, 50),
            'customer_id' => $this->faker->numberBetween(1, 10),
            'comment' => $this->faker->text(),
            'rating' => $this->faker->numberBetween(1, 5),
        ];
    }
}