<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';
    
    protected $fillable = [
        'name',
        'code',
        'short_name',
        'is_active',
        'is_deleted',
        'deleted_at',
        'deleted_by',
        'created_by',
        'updated_by',
    ];
}