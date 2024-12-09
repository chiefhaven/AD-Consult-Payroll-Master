<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
// use DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get counts for each qualification type
        $education_levels = Employee::select('education_level', DB::raw('count(*) as total'))
                    ->groupBy('education_level')
                    ->get();
                    
        $monthly_billings = DB::table('billings')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get();

        // Pass the data to the view
        return view('home', compact('education_levels','monthly_billings'));
    }
    
}