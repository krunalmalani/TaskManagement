<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';
    
    protected $fillable = [
        'company_id',
        'branch_id',
        'name',
        'code',
        'color_code',
        'description',
        'parent_department_id',
        'head_role_id',
        'manager_id',
        'scope',
        'is_active',
        'is_deleted',
        'deleted_at',
        'deleted_by',
        'created_by',
        'updated_by',
    ];
}