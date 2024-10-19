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
        $billing = Billing::all();
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
        //
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
