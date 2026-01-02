<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDepartmentController extends Controller
{
    public function list_department()
    {   
        return view('admin.department.list_department');
    }
}
