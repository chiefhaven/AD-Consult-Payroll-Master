<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Sample data
        $projects = [
            [
                'id' => (string) \Illuminate\Support\Str::uuid(), // Generate a UUID
                'name' => 'Project Alpha',
                'description' => 'This is a description for Project Alpha.',
                'client_id' => '2d353556-e143-3ced-b587-a7126ce11f03', // Example client UUID
                'start_date' => '2024-01-01',
                'end_date' => '2024-06-01',
                'status' => 'active',
            ],
            [
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'name' => 'Project Beta',
                'description' => 'This is a description for Project Beta.',
                'client_id' => '3e4f35b2-0c51-3d0b-8e2c-3e43ef38a77a', // Example client UUID
                'start_date' => '2024-02-01',
                'end_date' => '2024-07-01',
                'status' => 'completed',
            ],
            [
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'name' => 'Project Gamma',
                'description' => 'This is a description for Project Gamma.',
                'client_id' => '4d56f39e-1c51-4b0b-8e2d-4f53ef38a77b', // Example client UUID
                'start_date' => '2024-03-01',
                'end_date' => null, // Ongoing project
                'status' => 'active',
            ],
            // Add more projects as needed
        ];

        // Insert data into the projects table
        DB::table('projects')->insert($projects);
    }

}
