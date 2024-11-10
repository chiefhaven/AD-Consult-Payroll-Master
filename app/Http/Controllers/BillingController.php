<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Http\Requests\StoreBillingRequest;
use App\Http\Requests\UpdateBillingRequest;
use App\Models\Client;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Product;

class BillingController extends Controller
{
    /**
     * Display a listing of invoices.
     */
    public function index()
    {
        $billing = Billing::with('products', 'payments')->where('billing_type', 'invoice')->get();
        return view("billing.sales", compact("billing"));
    }

    /**
     * Display a listing of the resource.
     */
    public function indexQuotations()
    {
        $billing = Billing::with('products', 'payments')->where('billing_type', 'quotation')->get();
        return view("billing.quotations", compact("billing"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $action = 'add';

        $clients = Client::all();
        $products = Product::all();

        $post = $request->all();

        // Check if 'clientId' is defined in the request and is not null
        $client = null; // Default to null
        if (isset($post['client'])) {
            $client = Client::find($post['client']); // Find the client
        }

        return view("billing.add-sale", compact('clients', 'products', 'client', 'action'));
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
            'billing_type' => 'invoice',
            'bill_status' => $state['status'],
            'billing_date' => $state['saleDate'],
            'paymentTerms' => $state['paymentTerms'],
            'termsUnits' => $state['termsUnits'],
            'status' => $state['status'],
            'total_amount' => $grandTotal,
            'invoice_number' => 'AD-'. random_int(1,100),
        ]);

        // Loop through products and attach them to the order
        foreach ($products as $product) {
            $order->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'total' => $product['total'],
                'item_discount' => $product['discount'],
                'tax' => $product['taxAmount'],
                'taxType' => $product['tax'] == "None" ? 'None': 1,
            ]);
        }

        // If a payment has been made, create the payment record
        if (isset($state['paid_amount']) && $state['paid_amount'] > 0) {
            // Save the payment in the database
            $payment = new Payment();
            $payment->billing_id = $order->id;  // Link to the billing order
            $payment->payment_amount = $state['paid_amount'];
            $payment->payment_method = $state['payment_method'];
            $payment->cheque_number = $state['payment_method'] === 'cheque' ? $state['chequeAccountNumber'] : null;
            $payment->account_number = $state['payment_method'] === 'bank_transfer' ? $state['chequeAccountNumber'] : null;
            $payment->payment_date = now();  // Or use the specific payment date
            $payment->save();
        }

        // Return response
        return response()->json([
            'data'=> $data,
            'order' => $order,
            'products' => $order->products,
            'grandTotal' => $grandTotal,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            // Find the bill and include related payments and products
            $bill = Billing::with(['payments', 'products', 'client'])->findOrFail($id);

            return response()->json($bill, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Bill not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching bill details.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Billing $billing)
    {
        $action = 'edit';
        return view('billing.add-sale', compact('billing', 'action'));
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
    public function destroy($id)
    {
        try {
            // Attempt to find the bill
            $bill = Billing::findOrFail($id);

            // Delete the bill if found
            $bill->delete();

            // Force delete payments if soft deletes are enabled
            $bill->payments()->forceDelete();

            // Return a success response
            return response()->json([
                'message' => 'Bill and associated payments deleted successfully.',
                'data' => $bill->payments
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Return an error if the bill was not found
            return response()->json(['message' => 'Bill not found.'], 404);
        } catch (\Exception $e) {
            // Handle any other errors
            return response()->json(['message' => 'Error deleting bill', 'error' => $e->getMessage()], 500);
        }

    }
}
