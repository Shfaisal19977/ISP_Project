<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use Faker\Generator as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $this->createUsers($faker, 50); // Replace 50 with the desired number of users
    }

    private function createUsers(Faker $faker, int $count)
    {
        for ($i = 0; $i < $count; $i++) {
            User::factory()->create([
                'email' => $faker->unique()->email(),
                'password' => bcrypt($faker->password()),
                'phone_number' => $faker->phoneNumber(),
                'national_id' => $faker->numerify('##########'),
                'remember_token' => Str::random(10),
                'city' => $faker->city(),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
