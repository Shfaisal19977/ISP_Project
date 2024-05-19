<?php

namespace Database\Seeders;

use App\Models\IptvSubscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subscription;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subscription::factory(10)->create();
        IptvSubscription::factory(10)->create();
    }
}
