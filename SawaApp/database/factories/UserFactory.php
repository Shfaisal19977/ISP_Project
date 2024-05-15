<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $areaCodes = [
            "Damascus" => "11",
            "Aleppo" => "21",
            "Homs" => "31",
            "Latakia" => "41",
            // You can add more cities here if needed
        ];
        $syrianCities = [
            "Damascus",
            "Aleppo",
            "Homs",
            "Latakia",
            "Deir ez-Zor",
            "Hama",
            "Idlib",
            "Raqqa",
            "Daraa",
            "Tartus",
        ];

        $city = $this->faker->randomElement(array_keys($areaCodes));
        $areaCode = isset($areaCodes[$city]) ? $areaCodes[$city] : array_rand($areaCodes);

        return [
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt($this->faker->password()), // Generate and hash a random password
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'phone_number' => function () use ($areaCode) {
                $subscriberNumber = str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT);
                return '0' . $areaCode . '-' . $subscriberNumber;
            },
            'national_id' => $this->faker->numerify('#############'),
            'city' => $city,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
