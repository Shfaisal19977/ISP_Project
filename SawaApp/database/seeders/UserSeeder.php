<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createUsers(100);
    }

    private function createUsers(int $count)
    {
        User::factory($count)->create();
    }
}
