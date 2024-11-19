<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Http\Requests\StoreSettingsRequest;
use App\Http\Requests\UpdateSettingsRequest;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('settings.settings');
    }

    public function businessInfo()
    {
        try {
            $businessInfo = Settings::select('key', 'value')->get(); // Replace 'key', 'value' with actual columns
            return response()->json($businessInfo, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch business information.'], 500);
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
    public function store(StoreSettingsRequest $request)
    {
        $validated = $request->validate([
            'prefix' => 'required|string|max:10',
            'seperator' => 'required|string|max:2',
            'startNumber' => 'required|integer|min:1',
            'taxRate' => 'required|numeric|min:0|max:100',
            'terms' => 'nullable|string',
            'header' => 'nullable|string',
            'footer' => 'nullable|string',
        ]);

        // Save settings logic (e.g., database update)
        Settings::updateOrCreate([], $validated);

        return response()->json(['message' => 'Settings saved successfully!'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Settings $settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingsRequest $request, Settings $settings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Settings $settings)
    {
        //
    }
}
