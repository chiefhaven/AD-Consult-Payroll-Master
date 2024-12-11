<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Http\Requests\StorepayrollRequest;
use App\Http\Requests\UpdatepayrollRequest;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    {
        // Fetch all payroll data
        $payrolls = Payroll::all();

        // Return a view and pass the payroll data
        return view('payrolls.payroll', ['payrolls' => $payrolls]);
    }
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
    public function store(StorepayrollRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(payroll $payroll)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(payroll $payroll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatepayrollRequest $request, payroll $payroll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(payroll $payroll)
    {
        //
    }
}