<?php

namespace App\Http\Controllers\sadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperAdminUserController extends Controller
{
    /**
     * Display the users management page
     */
    public function index()
    {
        return view('sadmin.users.index');
    }
}

