<?php

namespace App\Http\Controllers;

use App\Models\quotation;
use App\Http\Requests\StorequotationRequest;
use App\Http\Requests\UpdatequotationRequest;

class QuotationController extends Controller
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
    public function store(StorequotationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(quotation $quotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(quotation $quotation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatequotationRequest $request, quotation $quotation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(quotation $quotation)
    {
        //
    }
}
