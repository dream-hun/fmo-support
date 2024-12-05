<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Jacques MBABAZI',
            'email' => 'support@fmorwanda.org',
        ]);
        $this->call([
            EcdSeeder::class,
            VslaSeeder::class,
            ScholarshipSeeder::class,
            ZamukaSeeder::class,
            MvtcSeeder::class,
            MusaSeeder::class,
            MusaSupportSeeder::class,
            UrgentCommunitySeeder::class,
            UrgentSupportSeeder::class,
            MemberSeeder::class,
            ToolkitSeeder::class,
            MalnutritionSeeder::class,
            MalnutritionSupportSeeder::class,
            TreesSeeder::class,
            TreeSupportSeeder::class,
            SchoolFeedingSeeder::class,
        ]);
    }
}
