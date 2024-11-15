<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Billing;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StorePaymentRequest $request, Billing $billing)
    {

        $data = $request->all();
        $state = $data['state'];

        Payment::create([
            'billing_id' => $data['bill'],
            'payment_amount' => $state['amountToPay'],
            'payment_method' => $state['payment_method'],
            'cheque_number' => $state['payment_method'] === 'cheque' ? $state['chequeAccountNumber'] : null,
            'account_number' => $state['payment_method'] === 'bank_transfer' ? $state['chequeAccountNumber'] : null,
            'payment_date' => $state['payment_date'],
            'created_by' => Auth::user()->id,

        ]);

        // Return response
        return response()->json(['message' => 'Payment saved'  ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
