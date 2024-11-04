<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use App\Http\Requests\StoreHolidayRequest;
use App\Http\Requests\UpdateHolidayRequest;
use Illuminate\Validation\ValidationException;

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
        $post = $request->all();

        $holiday = new Holiday();
        $holiday->name = $post['name'];
        $holiday->description = $post['description'];
        $holiday->type = $post['holiday_type'];
        $holiday->date = $post['date'];
        $holiday->recurring = filter_var($post['recurring'], FILTER_VALIDATE_BOOLEAN);

        $holiday->save();

        return response()->json($holiday, 200);
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
    public function update(UpdateHolidayRequest $request, $id)
    {
        try {
            $post = $request->all();

            // Find the designation by ID
            $holiday = Holiday::findOrFail($id);

            // Update the holiday fields
            $holiday->name = $post['name'];
            $holiday->description = $post['description'];
            $holiday->type = $post['holiday_type'];
            $holiday->date = $post['date'];
            $holiday->recurring = filter_var($post['recurring'], FILTER_VALIDATE_BOOLEAN);

            $holiday->save();

            // Return a response with the updated holiday
            return response()->json($holiday, 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating holiday', 'error' => $e->getMessage()], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Holiday $holiday)
    {
        try {
            // Delete the holiday
            $holiday->delete();

            // Return a success response
            return response()->json(['message' => 'Holiday deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting holiday', 'error' => $e->getMessage()], 500);
        }
    }

}
