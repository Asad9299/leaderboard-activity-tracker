<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Activity;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory(10)->create()->each(function ($user) {
            foreach (range(1, rand(5, 15)) as $i) {
                Activity::create([
                    'user_id' => $user->id,
                    'performed_at' => now()->subDays(rand(0, 10))->setTime(rand(5,22), rand(0,59)),
                    'points' => 20,
                ]);
            }
        });
        
    }
}
