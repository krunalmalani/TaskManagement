<?php

namespace App\Http\Controllers\sadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperAdminDashboardController extends Controller
{
    public function superAdminDashboard()
    {   
        return view('sadmin.dashboard.super-admin');
    }
}
