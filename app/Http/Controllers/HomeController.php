<?php

namespace App\Http\Controllers;

use App\Models\PayeBracket;
use Illuminate\Http\Request;

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
        $payeBrackets = PayeBracket::orderBy('limit')->get();
        return view('home', compact('payeBrackets'));
    }
}
