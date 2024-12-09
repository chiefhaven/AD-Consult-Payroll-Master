<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use Illuminate\Http\Request;

use PDF;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    // Fetch all billings with their related orders
    $billings = Billing::with(['orders'])->get();

    // Initialize the total amount
    $total = 0;

    // Calculate totals for each billing record
    foreach ($billings as $billing) {
        $subtotal = $billing->orders->sum(function ($order) {
            $itemTotal = $order->quantity * $order->rate;

            // Apply tax if available
            if (isset($order->tax)) {
                $itemTotal += ($itemTotal * ($order->tax / 100));
            }

            return $itemTotal;
        });

        // Calculate total by applying discount
        // $billing->total = $subtotal - ($subtotal * ($billing->discount / 100));

        // Add the current billing's total to the overall total
        $total += $billing->total;  // Calculate the overall total
    }

    // Pass both billings and total to the view
    return view('Billings.billing', compact('billings'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $billing = Billing::create([
        'client_id' => $request->client_id,
        'bill_type' => $request->bill_type,
        'total_amount' => $request->total_amount,
        'discount' => $request->discount,
        'paid_amount' => $request->paid_amount,
        'status' => $request->status,
        'balance' => $request->balance,
        'tax_amount' => $request->tax_amount,
        'discount_type' => $request->discount_type,
        'transaction_terms' => $request->transaction_terms,
        'description' => $request->description,
        'issue_date' => $request->issue_date,
        'due_date' => $request->due_date,
    ]);

    // Loop through products and create an order for each product
    foreach ($request->products as $product) {
        $billing->orders()->create([
            'product_id' => $product['id'],
            'quantity' => $product['quantity'],
            'rate' => $product['rate'],
            'total' => $product['quantity'] * $product['price'],
        ]);
    }

    return redirect()->route('billings.index');

    }

    /**
     * Display the specified resource.
     */
   public function show(string $id)
{
    // Fetch the billing record along with related orders and client
    $billing = Billing::with(['orders', 'client'])->findOrFail($id);

    // Calculate subtotal: only quantity * rate with tax included
    $subtotal = $billing->orders->sum(function ($order) {
        $itemTotal = $order->quantity * $order->rate;

        // Apply tax if available
        $itemTotal += ($itemTotal * (($order->tax ?? 0) / 100));

        return $itemTotal;
    });

    // Calculate total: subtotal with discount applied
    $total = $subtotal;
    $total -= ($total * (($billing->discount ?? 0) / 100)); // Apply discount if available

    // Determine which view to return based on billing type
    if ($billing->bill_type === 'invoice') {
        return view('billings.billingView', compact('billing'));
    } elseif ($billing->bill_type === 'quotation') {
        return view('billings.billingViewQuotation', compact('billing'));
    }

    return redirect()->back()->with('error', 'Billing type not recognized.');
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        return view('Billings.billingEdit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function downloadInvoice($id)
    {
        // Get the billing data for the invoice
        $billing = Billing::findOrFail($id);

        // Load the view and pass the billing data
        $pdf = PDF::loadView('billings.invoice_pdf', compact('billing'));

        // Set the filename
        $filename = 'Invoice_' . $billing->id . '.pdf';

        // Return the PDF download response
        return $pdf->download($filename);
    }

    public function downloadQuotation($id)
    {
        // Get the billing data for the invoice
        $billing = Billing::findOrFail($id);

        // Load the view and pass the billing data
        $pdf = PDF::loadView('billings.quotation_pdf', compact('billing'));

        // Set the filename
        $filename = 'Quotation_' . $billing->id . '.pdf';

        // Return the PDF download response
        return $pdf->download($filename);
    }



}