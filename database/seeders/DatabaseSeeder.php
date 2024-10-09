<?php

namespace Database\Seeders;

use App\Models\Billing;
use App\Models\Employee;
use App\Models\Client;
use App\Models\Designation;
use App\Models\Industry;
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
        Billing::factory()->count(50)->create([
            // 'status' => 'Active',
            ]);

        Employee::factory()->count(50)->create([
            'status' => 'Active',
            ]);

        Client::factory()->count(50)->create([
            'status' => 'Active',
            ]);

        User::factory()->count(50)->create();

        User::factory()->create([
            'username' => 'Test',
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Industry::factory()->create([
            'name' => 'Health',
        ]);

        Industry::factory()->count(4)->create();

        Designation::factory()->count(4)->create();

        Designation::factory()->create([
            'name' => 'Accountant',
            'description' => 'For all field officers'
        ]);
    }
}
