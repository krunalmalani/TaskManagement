<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminRolePermissionController extends Controller
{
    public function list_role()
    {   
        return view('admin.role.list_role');
    }
}
