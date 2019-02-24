<?php

namespace App\Http\Controllers;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->user_type_id == 2) {
            return redirect(route('users.paymentPanel'));
        } else if(auth()->user()->user_type_id > 2) {
            return redirect(route('users.account'));
        }
        
        return view('home');
    }
}
