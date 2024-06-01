<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'picture' => $this->faker->imageUrl(640, 480, 'people', true),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'phone_number' => $this->faker->phoneNumber,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Configure the factory to generate an admin user.
     *
     * @return $this
     */
    public function admin(): UserFactory
    {
        return $this->afterCreating(function (User $user) {
            $user->token = 'A_' . $user->id . '_' . now()->format('YmdHis');
            $user->save();
        });
    }

    /**
     * Configure the factory to generate a regular user.
     *
     * @return $this
     */
    public function user(): UserFactory
    {
        return $this->afterCreating(function (User $user) {
            $user->token = 'U_' . $user->id . '_' . now()->format('YmdHis');
            $user->save();
        });
    }
}
