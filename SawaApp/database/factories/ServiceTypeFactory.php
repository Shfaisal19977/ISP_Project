<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceType>
 */
class ServiceTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $serviceTypes = ['adsl', 'IPTV']; // Add more service types as needed
        return [
            'name' => $this->faker->randomElement($serviceTypes),
            'description' => $this->faker->randomElement(['Internet Protocol Television', 'Asymmetric Digital Subscriber Line']),
        ];
    }
}
