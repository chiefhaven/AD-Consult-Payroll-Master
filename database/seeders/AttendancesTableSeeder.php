<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttendancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Sample employee IDs (UUIDs) for seeding purposes
        $employeeIds = [
            'e1f625d3-6a27-4f8a-9a53-839db1d8b8d5',
            'ae02ffb4-7e4c-4c8a-925a-4c5c4e63b9c6',
            'c73ddf98-1b7a-4f95-a3b3-fb9f8b076537',
        ];

        // Define sample data entries
        foreach ($employeeIds as $employeeId) {
            for ($i = 0; $i < 10; $i++) {
                $checkIn = Carbon::parse('08:00')->addMinutes(rand(0, 30));
                $checkOut = Carbon::parse('17:00')->subMinutes(rand(0, 30));
                $workingHours = $checkIn->diffInMinutes($checkOut) / 60;

                DB::table('attendances')->insert([
                    'id' => Str::uuid(),
                    'employee_id' => $employeeId,
                    'attendance_date' => Carbon::now()->subDays($i),
                    'status' => ['present', 'absent', 'on leave', 'late'][rand(0, 3)],
                    'check_in_time' => $checkIn->format('H:i:s'),
                    'check_out_time' => $checkOut->format('H:i:s'),
                    'working_hours' => $workingHours,
                    'remarks' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
