<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyBranch extends Model
{
    use HasFactory;
    
    protected $table = 'company_branches';

    protected $fillable = [
        'company_id',
        'branch_id',
    ];
}
