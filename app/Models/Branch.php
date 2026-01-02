<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'branches';
    
    protected $fillable = [
        'company_id',
        'name',
        'code',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'is_head_office',
        'is_active',
        'is_deleted',
        'deleted_at',
        'deleted_by',
        'settings',
        'manager_id',
        'created_by',
        'updated_by',
    ];
}