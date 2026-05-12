<?php

namespace App\Http\Controllers\PanelControl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('controlpanel.dashboard');
    }
    
    public function fav(Request $request)
    {
        return view('controlpanel.fav');
    }
    //
}
