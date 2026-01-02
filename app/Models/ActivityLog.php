<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_logs';
    
    protected $fillable = [
        'user_id',
        'company_id',
        'branch_id',
        'department_id',
        'module',
        'title',
        'description',
        'log_name',
        'properties',
        'ip_address',
        'user_agent'
    ];
}