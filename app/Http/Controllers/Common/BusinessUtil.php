<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Industry;
use App\Models\User;

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
        // Define the tax brackets
        $brackets = [
            [150000, 0],        // 0% for the first MK 150,000
            [350000, 0.25],     // 25% for the next MK 350,000
            [2050000, 0.30],    // 30% for the next MK 2,050,000
            [PHP_INT_MAX, 0.35] // 35% for amounts over MK 2,550,000
        ];

        // Initialize the total tax
        $tax = 0;

        // Calculate the taxable income for each bracket
        foreach ($brackets as $index => $bracket) {
            // Get the current bracket's limit and rate
            $limit = $bracket[0];
            $rate = $bracket[1];

            if ($index === 0) {
                // First MK 150,000 - no tax
                if ($salary <= $limit) {
                    break;
                }
            } else {
                // Calculate taxable income for each bracket
                $previousLimit = $brackets[$index - 1][0];
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
}
