<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ServiceType;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bundleSizes = ['100GB', '5GB', '10GB', '30GB', '50GB', '75GB'];
        $speeds = ['1MB', '4MB', '8MB', '16MB'];

        return [
            'user_id' => User::factory(),
            'bundle_size' => $this->faker->randomElement($bundleSizes),
            'current_usage' => $this->faker->numberBetween(0, 100),
            'start_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'speed' => $this->faker->randomElement($speeds),
            'service_type_id' => ServiceType::factory(),  // Replace with this line


        ];
    }
}
