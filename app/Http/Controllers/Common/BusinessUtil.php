<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
