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
        // Demo accounts only. Password for all of them is "password".
        User::factory()->principal()->create([
            'name' => 'Demo Principal',
            'email' => 'principal@example.com',
        ]);

        User::factory()->teacher()->create([
            'name' => 'Demo Teacher',
            'email' => 'teacher@example.com',
        ]);

        User::factory()->student()->create([
            'name' => 'Demo Student',
            'email' => 'student@example.com',
        ]);
    }
}
