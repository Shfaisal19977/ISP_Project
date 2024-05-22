<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Channel;
use App\Models\IptvSubscription;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Channel>
 */
class ChannelFactory extends Factory
{
    protected $model = Channel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::pluck('id');

        return [
            'name' => $this->faker->company,
            'category' => $this->faker->randomElement(['News', 'Sports', 'Entertainment', 'Kids', 'Music']),
            'iptv_subscription_id' => function () use ($userIds) {
                $userId = $userIds->random();
                $iptvSubscription = IptvSubscription::where('user_id', $userId)->first();
                if (!$iptvSubscription) {
                    $iptvSubscription = IptvSubscription::factory()->create(['user_id' => $userId]);
                }
                return $iptvSubscription->id;
            },
        ];
    }
}
