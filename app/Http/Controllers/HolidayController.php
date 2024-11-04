<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use App\Http\Requests\StoreHolidayRequest;
use App\Http\Requests\UpdateHolidayRequest;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $holidays = Holiday::all();
        // $today = now();
        // $holidays = Holiday::where(function ($query) use ($today) {
        //     $query->where('date', $today->format('Y-m-d'))
        //         ->orWhere(function ($query) use ($today) {
        //             $query->where('recurring', true)
        //                     ->whereMonth('date', $today->month)
        //                     ->whereDay('date', $today->day);
        //         });
        // })->get();
        return response()->json($holidays);
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
    public function store(StoreHolidayRequest $request)
    {
        $holiday = new Holiday();
        $holiday->name = $request->name;
        $holiday->description = $request->description;

        $holiday->save();

        return response()->json($holiday,200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Holiday $holiday)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Holiday $holiday)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHolidayRequest $request, Holiday $holiday)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Holiday $holiday)
    {
        //
    }
}
