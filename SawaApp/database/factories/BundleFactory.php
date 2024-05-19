<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Bundle;
use App\Models\Subscription;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bundle>
 */
class BundleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Bundle::class;

    public function definition()
    {
        $maxSpeedPrices = [
            '1MB' => 10,
            '4MB' => 20,
            '8MB' => 30,
            '16MB' => 40,
        ];
        $subscription = Subscription::inRandomOrder()->first();
        $maxSpeed = $subscription->speed;
        return [
            'user_id' => User::factory(),
            'bundle_type' => $this->faker->word,
            'max_speed' => intval($maxSpeed),
            'price' => $maxSpeedPrices[$maxSpeed],

            'max_bundle' => $this->faker->numberBetween(1, 10),
        ];
    }
}
