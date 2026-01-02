<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';
    
    protected $fillable = [
        'name',
        'code',
        'logo',
        'website',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'zip_code',
        'tax_id',
        'registration_number',
        'is_active',
        'is_deleted',
        'deleted_at',
        'deleted_by',
        'registration_date',
        'description',
        'created_by',
        'updated_by',
    ];
}