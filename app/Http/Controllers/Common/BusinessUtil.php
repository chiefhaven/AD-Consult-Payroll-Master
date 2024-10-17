<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Industry;
use App\Models\PayeBracket;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

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
        // Get the current tax brackets from the database
        $brackets = PayeBracket::orderBy('limit')->get();

        // Initialize the total tax
        $tax = 0;

        // Calculate the taxable income for each bracket
        foreach ($brackets as $index => $bracket) {
            $limit = $bracket->limit;
            $rate = $bracket->rate;

            if ($index === 0) {
                // First bracket - no tax
                if ($salary <= $limit) {
                    break;
                }
            } else {
                // Calculate taxable income for each bracket
                $previousLimit = $brackets[$index - 1]->limit;
                if ($salary > $previousLimit) {
                    $taxableIncome = min($salary - $previousLimit, $limit - $previousLimit);
                    $tax += $taxableIncome * $rate;
                } else {
                    break;
                }
            }
        }

        return $tax;
    }

    public function updatePayeBrackets(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'brackets.*.limit' => 'required|numeric',
            'brackets.*.rate' => 'required|numeric|min:0|max:1', // Adjust range if necessary
        ]);

        // Get the brackets from the request
        $brackets = $request->input('brackets');

        // Use a transaction to ensure atomicity
        DB::beginTransaction();
        try {
            // Clear existing brackets
            PayeBracket::truncate();

            // Bulk insert the new brackets using Eloquent's insert method
            PayeBracket::insert($brackets);

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
            return response()->json([$e->getMessage()], 200);
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
     * Display a listing of the resource.
     */
    public function searchProduct(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'LIKE', "%{$query}%")->orWhere('description', 'LIKE', "%{$query}%")->pluck('name');

        return response()->json($products);
    }
}
