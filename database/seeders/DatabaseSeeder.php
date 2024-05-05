<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Client;
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
        Employee::factory()->count(50)->create([
            'status' => 'Active',
            ]);

        Client::factory()->count(50)->create([
            'status' => 'Active',
            ]);

        User::factory()->create([
            'username' => 'Test',
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->count(50)->create();
    }
}
