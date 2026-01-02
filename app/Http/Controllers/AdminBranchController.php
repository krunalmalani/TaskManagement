<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminBranchController extends Controller
{
    public function list_branch()
    {   
        return view('admin.branch.list_branch');
    }
}