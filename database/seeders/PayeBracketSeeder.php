<?php

namespace Database\Seeders;

use App\Models\PayeBracket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str; // Make sure to include this

class PayeBracketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define your tax brackets
        $brackets = [
            ['limit' => 150000, 'rate' => 0.00],     // 0% on first K150,000
            ['limit' => 350000, 'rate' => 0.25],    // 25% on K150,001 to K500,000
            ['limit' => 2050000, 'rate' => 0.30],   // 30% on K500,001 to K2,550,000
            ['limit' => PHP_INT_MAX, 'rate' => 0.35], // 35% on any amount above K2,550,000
        ];

        // Insert the tax brackets into the PayeBracket table
        foreach ($brackets as $bracket) {
            PayeBracket::create([
                'id' => Str::uuid(), // Generate a UUID for the id
                'limit' => $bracket['limit'],
                'rate' => $bracket['rate'],
            ]);
        }
    }
}
