<?php

namespace App\Http\Controllers;

use App\Models\HRM;
use App\Http\Requests\StoreHRMRequest;
use App\Http\Requests\UpdateHRMRequest;
use App\Models\Designation;
use App\Models\LeaveType;

class HRMController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("hrm.hrm");
    }

    /**
     * Display a listing of the resource.
     */
    public function designationIndex()
    {
        $designations = Designation::all();
        return response()->json($designations);
    }

    /**
     * Display a listing of the resource.
     */
    public function leaveTypesIndex()
    {
        $leaveTypes = LeaveType::all();
        return response()->json($leaveTypes);
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
    public function store(StoreHRMRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(HRM $hRM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HRM $hRM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHRMRequest $request, HRM $hRM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HRM $hRM)
    {
        //
    }
}
