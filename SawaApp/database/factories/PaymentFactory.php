<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Payment;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'amount' => $this->faker->randomFloat(2, 10, 500),
            'payment_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'bundle_id' => \App\Models\Bundle::factory(),
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal', 'bank_transfer']),
        ];
    }
}
