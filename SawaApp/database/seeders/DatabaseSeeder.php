<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Channel;
use App\Models\Subscription;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SubscriptionSeeder::class,
            ServiceTypeSeeder::class,
            NotificationSeeder::class,
            BundleSeeder::class,
            PaymentSeeder::class,
            IptvSeeder::class,
            ChannelSeeder::class,

        ]);
        $channels = Channel::factory()->count(5)->create();
        $subscriptions = Subscription::all();
        foreach ($subscriptions as $subscription) {
            $subscription->channels()->attach($channels->random(2));
        }
    }
}
