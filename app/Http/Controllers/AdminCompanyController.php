<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminCompanyController extends Controller
{
    public function list_company()
    {   
        return view('admin.company.list_company');
    }
}
