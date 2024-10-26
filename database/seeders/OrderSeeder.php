<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Billing;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $billings = Billing::factory()->count(10)->create(); // Create 10 billing records
        $products = Product::factory()->count(5)->create(); // Create 5 products

        // Create orders for each billing
        foreach ($billings as $billing) {
            // Create a random number of orders for each billing
            Order::factory()->count(rand(1, 3))->create([
                'billing_id' => $billing->id,
                'product_id' => $products->random()->id, // Assign a random product
            ]);
    }

    }
}