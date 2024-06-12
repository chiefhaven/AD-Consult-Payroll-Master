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
        dd();
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
}
