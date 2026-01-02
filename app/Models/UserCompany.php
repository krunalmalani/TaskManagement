<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserCompany extends Model
{
    use HasFactory;
    
    protected $table = 'user_companies';

    protected $fillable = [
        'user_id',
        'company_id',
    ];
}