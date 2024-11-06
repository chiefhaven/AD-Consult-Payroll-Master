<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Http\Requests\StoreBillingRequest;
use App\Http\Requests\UpdateBillingRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Product;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $billing = Billing::with('products')->get();
        return view("billing.index", compact("billing"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $clients = Client::all();
        $products = Product::all();

        $post = $request->all();

        // Check if 'clientId' is defined in the request and is not null
        $client = null; // Default to null
        if (isset($post['client'])) {
            $client = Client::find($post['client']); // Find the client
        }

        return view("billing.add-sale", compact('clients', 'products', 'client'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBillingRequest $request)
    {
        // Retrieve all data from the request
        $data = $request->all();

        // Extract products and state from the request data
        $products = $data['products'];
        $state = $data['state'];

        // Initialize a variable to keep track of the grand total
        $grandTotal = 0;

        // Loop through each product to calculate the total price
        foreach ($products as $product) {
            $productTotal = $product['price'] * $product['quantity'];
            $grandTotal += $productTotal;
        }

        // Example: Saving the order in the database (adjust based on your schema)
        $order = Billing::create([
            'client_id' => $request->client, // Assuming you have a client ID
            'billing_date' => $state['saleDate'],
            'due_date' => $state['dueDate'],
            'status' => $state['status'],
            'total_amount' => $grandTotal,
            'invoice_number' => 'AD-'. random_int(1,100),
        ]);

        // Loop through products and attach them to the order
        foreach ($products as $product) {
            $order->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'total' => $product['quantity'] * $product['price'],
            ]);
        }

        // Return response
        return response()->json([
            'order' => $order,
            'products' => $order->products,
            'grandTotal' => $grandTotal,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Billing $billing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Billing $billing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBillingRequest $request, Billing $billing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Billing $billing)
    {
        //
    }
}
