<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Http\Requests\StoreSettingsRequest;
use App\Http\Requests\UpdateSettingsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

class SettingsController extends Controller
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
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('settings.settings');
    }

    public function businessInfo()
    {
        try {
            $businessInfo = $this->settings;
            return response()->json($businessInfo, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch business information.'], 500);
        }
    }

    public function getInvoiceSettings()
    {
        try {
            $validated = [
                'prefix' => $this->settings->prefix, // e.g., "AD"
                'suffix' => $this->settings->invoice_number_suffix, // e.g., "client_name"
                'separator' => $this->settings->invoice_number_seperator, // e.g., "-"
                'invoiceNumberIncludeYear' => (bool) $this->settings->invoiceNumberIncludeYear, // "1" becomes true
                'invoiceNumberIncludeClientName' => (bool) $this->settings->invoiceNumberIncludeClientName, // "1" becomes true
                'companyName' => $this->settings->company_name, // e.g., "AD Consult"
                'phoneNumber' => $this->settings->phone_number, // e.g., "+2659990000000"
                'terms' => $this->settings->terms,
                'footer' => $this->settings->footer,
                'header' => $this->settings->header,
            ];

            return response()->json($validated, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve invoice settings.'], 500);
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

    public function updateInvoiceSettings(Request $request)
    {
        $validated = $request->validate([
            'prefix' => 'required|string',
            'startNumber' => 'required|numeric',
            'taxRate' => 'required|numeric',  // Changed from 'string' to 'numeric'
            'terms' => 'nullable|string',
            'header' => 'required|string',  // Removed 'in' rule
            'footer' => 'required|string',  // Changed from 'email' to 'string'
            'seperator' => 'required|string',
            'invoiceNumberIncludeClientName' => 'required|boolean',  // Changed to boolean validation
            'invoiceNumberIncludeYear' => 'required|boolean',  // Changed to boolean validation
        ]);

        // Update the settings table
        $settings = Settings::first();
        $settings->prefix = $validated['prefix'];
        $settings->startNumber = $validated['startNumber'];
        $settings->taxRate = $validated['taxRate'];
        $settings->terms = $validated['terms'];
        $settings->header = $validated['header'];
        $settings->footer = $validated['footer'];
        $settings->seperator = $validated['seperator'];
        $settings->invoiceNumberIncludeClientName = $validated['invoiceNumberIncludeClientName'];
        $settings->invoiceNumberIncludeYear = $validated['invoiceNumberIncludeYear'];
        $settings->save();

        // Clear configuration cache
        Artisan::call('config:clear');

        // Return a success response
        return response()->json(['message' => 'Invoice settings updated successfully.']);

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
