<?php

namespace Database\Seeders;

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
        $this->call(ProjectsTableSeeder::class);
        $this->call(AttendancesTableSeeder::class);

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
            'email' => 'haven@haven-techmw.com',
            'password' => bcrypt('password'), // Hash the password
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
