<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'name',
        'code',
        'symbol',
        'country_id',
        'is_active',
        'is_deleted',
        'deleted_at',
        'deleted_by',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the country that owns the currency
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
