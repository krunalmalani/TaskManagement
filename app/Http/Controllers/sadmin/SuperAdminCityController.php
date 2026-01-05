<?php

namespace App\Http\Controllers\sadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperAdminCityController extends Controller
{
    public function index()
    {
        return view('sadmin.city.index');
    }
}
