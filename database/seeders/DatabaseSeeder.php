<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Family admin account for attendance feature
        User::factory()->create([
            'name' => 'Keluarga Ibrahim',
            'email' => 'admin@ibrahim.sabira-iibs.id',
            'password' => bcrypt('Ibrahim2026!'),
        ]);
    }
}
