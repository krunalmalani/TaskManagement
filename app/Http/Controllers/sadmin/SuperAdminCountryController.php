<?php

namespace App\Http\Controllers\sadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperAdminCountryController extends Controller
{
    public function index()
    {
        return view('sadmin.country.index');
    }
}
