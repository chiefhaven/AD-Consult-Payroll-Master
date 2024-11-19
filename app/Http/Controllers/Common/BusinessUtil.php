<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Industry;
use App\Models\PayeBracket;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

class BusinessUtil extends Controller
{
    static function get_enum_values( $table, $field )
    {
        $tableName = $table;
        $columnName = $field;

        // Get enum column values
        $enumValues = DB::select("SHOW COLUMNS FROM $tableName WHERE Field = ?", [$columnName])[0]->Type;

        // Extract enum values from column definition
        preg_match("/^enum\((.*)\)$/", $enumValues, $matches);
        $enumOptions = [];
        if ($matches !== false && isset($matches[1])) {
            $enumOptions = explode(',', $matches[1]);
            $enumOptions = array_map(function($option) {
                return trim($option, "'");
            }, $enumOptions);
        }

        // $enumOptions now contains the enum values
        return $enumOptions;
    }

    static function get_industry()
    {
        $industries = Industry::all();
        return $industries;
    }

    static function get_industry_id($industry_name)
    {
        $industry_id = Industry::where('name', $industry_name)->firstOrFail()->id;
        return $industry_id;
    }

    public $clients = [];

    public function autocompleteclientSearch($client)
    {
        if ($client != '') {
            $this->clients = Client::where('client_name', 'LIKE', '%' . $client . '%')->orderBy('client_name', 'asc')->get();
        } else {
            $this->clients = [];
        }

        return $this->clients;
    }

    function calculatePaye($salary) {
        // Get tax brackets from the database, ordered by limit
        $brackets = PayeBracket::orderBy('limit')->get();

        // Initialize the total tax
        $tax = 0;

        // Loop through the tax brackets to calculate the tax
        foreach ($brackets as $index => $bracket) {
            $limit = (float) $bracket->limit; // Convert limit to float
            $rate = (float) $bracket->rate;   // Convert rate to float
            if ($index === 0) {
                // Handle the first bracket (0% tax on income up to the first limit)
                if ($salary <= $limit) {
                    break; // Stop the loop if salary is less than or equal to the first limit
                }
            } else {
                // For subsequent brackets, calculate based on the previous limit
                $previousLimit = (float) $brackets[$index - 1]->limit; // Get the previous limit

                if ($salary > $previousLimit) {
                    // Calculate the taxable income within the current bracket
                    $salary = $salary - $previousLimit;

                    $taxableIncome = min($salary, $limit);

                    // Calculate the tax for the current bracket
                    $tax += $taxableIncome * $rate;

                } else {
                    break; // Stop the loop if salary does not exceed the previous limit
                }
            }
        }

        // Round the total tax to 2 decimal places before returning
        return round($tax, 2);
    }



    public function updatePayeBrackets(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'brackets.*.limit' => 'required|numeric',
            'brackets.*.rate' => 'required|numeric|min:0|max:1', // Ensure rate is between 0 and 1
        ]);

        // Get the brackets from the request
        $brackets = $request->input('brackets');

        // Use a transaction to ensure atomicity
        DB::beginTransaction();
        try {
            // Clear existing brackets
            PayeBracket::truncate();

            // Prepare brackets for insertion, including UUIDs
            $dataToInsert = array_map(function ($bracket) {
                return [
                    'id' => (string) \Illuminate\Support\Str::uuid(), // Generate UUID
                    'limit' => $bracket['limit'],
                    'rate' => $bracket['rate'],
                    'created_at' => now(), // Set current timestamp
                    'updated_at' => now(), // Set current timestamp
                ];
            }, $brackets);

            // Bulk insert the new brackets using Eloquent's insert method
            PayeBracket::insert($dataToInsert);

            // Commit the transaction
            DB::commit();

            // Return a success message or redirect
            return response()->json([], 200);

        } catch (\Exception $e) {
            // Roll back the transaction in case of an error
            DB::rollBack();

            // Log the error for debugging purposes
            Log::error('Failed to update PAYE brackets: ' . $e->getMessage());

            // Return an error message to the user
            return response()->json(['error' => 'Failed to update PAYE brackets.']);
        }
    }


    // Method to get PAYE brackets
    public function getPayeBrackets(Request $request)
    {
        // Fetch all PAYE brackets from the database
        $brackets = PayeBracket::all(); // Retrieve all records

        // Return the brackets as a JSON response
        return response()->json($brackets);
    }


    static function date($payroll_date){
        // Create a DateTime object from the month-year string
        $date = \DateTime::createFromFormat('F Y', $payroll_date);

        // Check if the date was created successfully
        if ($date) {
            // Format the date as 'Y-m-d' (year-month-day)
            $payroll_date = $date->format('Y-m-01');
        } else {
            // Handle error if the date couldn't be created
            // e.g., throw an exception or set $payroll_date to null
            $payroll_date = null; // or handle the error appropriately
        }

        return $payroll_date;
    }

    /**
     * Search products for type ahead.
     */
    public function searchProduct(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'LIKE', "%{$query}%")->get();

        return response()->json($products);
    }

    /**
     * Search client for type ahead.
     */
    public function searchClient(Request $request)
    {
        $query = $request->get('query');
        $clients = Client::where('client_name', 'LIKE', "%{$query}%")->get();
        return response()->json($clients);
    }

    public function fetchClient(Request $request)
    {
        // Retrieve the client ID from the request
        $clientId = $request->post('clientId');

        // Fetch the client data from the database
        $clientData = Client::with('user')->find($clientId);

        // Check if client data is found
        if ($clientData) {
            // Return a success response with client data
            return response()->json([
                'success' => true,
                'data' => $clientData
            ], 200);
        } else {
            // Return a not found response
            return response()->json([
                'success' => false,
                'message' => 'Client not found.'
            ], 404);
        }
    }

    public function showProduct(Request $request)
    {
        $post = $request->all();
        // Find the product by ID
        $product = Product::find('24ee2cf3-8acc-11ef-9a69-8038fbc90d23');

        // Check if the product exists
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404); // Return a 404 response if not found
        }

        // Return the product data as JSON
        return response()->json($product);
    }

    /**
     * Get email settings from the .env file.
     */
    public function getEmailSettings()
    {
        try {
            $emailSettings = [
                'mail_host' => env('MAIL_HOST'),
                'mail_port' => env('MAIL_PORT'),
                'mail_username' => env('MAIL_USERNAME'),
                'mail_password' => '', // Do not expose the actual password
                'mail_encryption' => env('MAIL_ENCRYPTION'),
                'mail_from_address' => env('MAIL_FROM_ADDRESS'),
                'mail_from_name' => env('MAIL_FROM_NAME'),
            ];

            return response()->json($emailSettings, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve email settings.'], 500);
        }
    }

    public function updateEmailSettings(Request $request)
    {
        $validated = $request->validate([
            'mail_host' => 'nullable|string',
            'mail_port' => 'nullable|integer',
            'mail_username' => 'nullable|string',
            'mail_password' => 'nullable|string',
            'mail_encryption' => 'nullable|string',
            'mail_from_address' => 'nullable|email',
            'mail_from_name' => 'nullable|string',
        ]);

        // Filter out null values
        $filteredData = array_filter($validated, function ($value) {
            return !is_null($value);
        });

        // Update .env only if there is data to update
        if (!empty($filteredData)) {
            $this->updateEnv($filteredData);
        }

        return response()->json(['message' => 'Email settings updated successfully.']);
    }

    private function updateEnv($data)
    {
        $envFile = base_path('.env');
        $str = file_get_contents($envFile);

        foreach ($data as $key => $value) {
            $str = preg_replace("/^{$key}=.*$/m", "{$key}={$value}", $str);
        }

        file_put_contents($envFile, $str);
    }


}
