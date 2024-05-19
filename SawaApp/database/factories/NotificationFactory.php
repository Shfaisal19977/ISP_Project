<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create(); // Create a user to associate the notification with
        return [
            'id' => Str::uuid()->toString(),
            'type' => 'App\Notifications\UserNotification',
            'notifiable_type' => 'App\Models\User',
            'notifiable_id' => $user->id,
            'data' => json_encode(['message' => $this->faker->sentence(), 'type' => 'test']),
            'read_at' => null,
            'user_id' => User::factory(),

        ];
    }
}
