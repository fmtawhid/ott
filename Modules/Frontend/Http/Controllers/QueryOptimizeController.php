<?php

namespace Modules\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class QueryOptimizeController extends Controller
{

    public function optimize(Request $request)
    {
        $database = env('DB_DATABASE');

        $tables = \DB::select('SHOW TABLES');

        $combine = "Tables_in_".$database;

        $result = [];
        foreach($tables as $table)
        {
            $result['ANALYZE'][$table->$combine] = \DB::select('ANALYZE TABLE '.$table->$combine.'');
            $result['OPTIMIZE'][$table->$combine] = \DB::select('OPTIMIZE TABLE '.$table->$combine.'');
        }

        return $result;
    }
}


