<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IptvSubscription;

class IptvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IptvSubscription::factory(100)->create();
    }
}
