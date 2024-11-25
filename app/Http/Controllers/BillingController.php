<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Http\Requests\StoreBillingRequest;
use App\Http\Requests\UpdateBillingRequest;
use App\Models\Client;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Settings;

use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;

class BillingController extends Controller
{
    protected $settings;

    // Constructor with dependency injection and loading settings
    public function __construct()
    {
        $this->middleware('auth'); // Apply authentication middleware

        // Load settings from the database
        $this->settings = Settings::first();
    }

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
        dd($this->settings);
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

        // Retrieve settings for invoice numbering
        $settings = $this->settings;

        // Get the client name if it's needed in the invoice number
        $clientName = Client::find($request->client)->client_name ?? '';

        // Retrieve the last invoice's invoice_number, or set the starting number if none exists
        $lastInvoice = Billing::where('billing_type', 'invoice')->latest('id')->first();

        if ($lastInvoice) {
            // Extract the number after the last separator
            $parts = explode($settings->invoice_number_seperator ?? '-', $lastInvoice->invoice_number);
            $lastInvoiceNumber = intval(end($parts)); // Get the last numeric part and convert to integer
        } else {
            // Default to 0 if there is no last invoice
            $lastInvoiceNumber = 0;
        }

        // Increment to get the next sequential number
        $nextInvoiceNumber = $lastInvoiceNumber + 1;

        // Build the invoice number based on settings
        $invoiceNumber = $settings->invoice_number_prefix ?? '';

        // Use the separator from settings, or default to '-'
        $separator = $settings->invoice_number_seperator ?? '-';

        // Add year if specified in the settings
        if (isset($settings->invoice_number_year) && $settings->invoice_number_year === 'yes') {
            $invoiceNumber .= $separator . date('Y');
        }

        // Add client name if specified in the suffix setting
        if (isset($settings->invoice_number_suffix) && $settings->invoice_number_suffix === 'client_name') {
            $invoiceNumber .= $separator . $clientName;
        }

        // Add the sequential number, padded to 4 digits
        $invoiceNumber .= $separator . str_pad($nextInvoiceNumber, 4, '0', STR_PAD_LEFT);

        // Remove the leading separator if prefix is empty
        $invoiceNumber = ltrim($invoiceNumber, $separator);


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
            'invoice_number' => $invoiceNumber,
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
        if (!empty($state['amountToPay']) && $state['amountToPay'] > 0) {
            Payment::create([
                'billing_id' => $order->id,
                'payment_amount' => $state['amountToPay'],
                'payment_method' => $state['payment_method'],
                'cheque_number' => $state['payment_method'] === 'cheque' ? $state['chequeAccountNumber'] : null,
                'account_number' => $state['payment_method'] === 'bank_transfer' ? $state['chequeAccountNumber'] : null,
                'payment_date' => $state['payment_date'],
            ]);
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
        // Load related products and tax rates directly onto the existing billing instance
        $billing->load(['products.taxRate']);
        return view('billing.edit-sale', compact('billing', 'action'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBillingRequest $request)
    {
        $data = $request->all();
        $products = $data['products'];
        $state = $data['state'];
        $bill = $data['billId'];

        $billing = Billing::find($bill);

        // Calculate the grand total from products
        $grandTotal = array_reduce($products, function ($total, $product) {
            return $total + ($product['price'] * $product['quantity']);
        }, 0);

        // Update the billing record in the database
        $billing->update([
            'client_id' => $request->client,
            'billing_type' => 'invoice',
            'bill_status' => $state['status'],
            'billing_date' => $state['saleDate'],
            'paymentTerms' => $state['paymentTerms'],
            'termsUnits' => $state['termsUnits'],
            'total_amount' => $grandTotal,
        ]);

        // Prepare pivot data for syncing products
        $productData = [];
        foreach ($products as $product) {
            $productData[$product['id']] = [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'total' => $product['total'],
                'item_discount' => $product['discount'],
                'tax' => $product['taxAmount'],
                'taxType' => $product['tax'] === "None" ? 'None' : 1,
            ];
        }
        $billing->products()->sync($productData);

        // Handle payment if provided
        if (!empty($state['amountToPay']) && $state['amountToPay'] > 0) {
            Payment::create([
                'billing_id' => $billing->id,
                'payment_amount' => $state['amountToPay'],
                'payment_method' => $state['payment_method'],
                'cheque_number' => $state['payment_method'] === 'cheque' ? $state['chequeAccountNumber'] : null,
                'account_number' => $state['payment_method'] === 'bank_transfer' ? $state['chequeAccountNumber'] : null,
                'payment_date' => $state['payment_date'],
            ]);
        }

        // Return response
        return response()->json([
            'data' => $data,
            'order' => $billing,
            'products' => $billing->products,
            'grandTotal' => $grandTotal,
        ], 200);

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

    public function billPdf(Billing $billing, $id, $action)
    {
        // Use the injected $billing model directly, no need to call find()
        $bill = $billing::with('products')->find($id);

        // If no bill is found, handle the error
        if (!$bill) {
            return abort(404, 'Bill not found');
        }

        // Ensure the property name is correct (assuming it's 'invoice_number')
        $pdf = PDF::loadView('pdf.billsDefault', ['bill' => $bill]);

        if ($action == 'print') {
            // Return the PDF as a downloadable file
            return $pdf->stream($bill->invoice_number . '.pdf');
        } else {
            // Stream the PDF to the browser
            return $pdf->download($bill->invoice_number . '.pdf');
        }
    }
}
