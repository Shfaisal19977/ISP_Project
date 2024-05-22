<?php

namespace Database\Factories;

use App\Models\IptvSubscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Channel;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IptvSubscription>
 */
class IptvSubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = IptvSubscription::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'package_name' => $this->faker->randomElement(['Basic Package', 'Premium Package', 'VIP Package']),
            'start_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'status' => $this->faker->randomElement(['active', 'suspended', 'cancelled']),
            'used_units' => $this->faker->numberBetween(0, 100),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (IptvSubscription $subscription) {
            $additionalShows = $this->faker->randomElement([5, 10, 15]);
            $subscription->additional_shows = $additionalShows;
            $subscription->save();
        });
    }
}
