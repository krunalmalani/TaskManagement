<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BranchDepartment extends Model
{
    use HasFactory;
    
    protected $table = 'branch_departments';

    protected $fillable = [
        'branch_id',
        'department_id',
    ];
}
