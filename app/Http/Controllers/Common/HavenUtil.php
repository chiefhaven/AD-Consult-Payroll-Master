<?php

namespace App\Http\Controllers;


class HavenUtil extends Controller
{
    function get_enum_values( $table, $field )
    {
        $type = fetchRowFromDB( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->Type;
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
        $enum = explode("','", $matches[1]);
        return $enum;
    },

    dd($enumValues);

}
