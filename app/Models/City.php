<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

    protected $fillable = [
        'state_id', 
        'name', 
        'is_active',
        'is_deleted',
        'deleted_at',
        'deleted_by',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_deleted' => 'boolean',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: State belongs to Country
     */
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    /**
     * Relationship: State created by User
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * Relationship: State updated by User
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    /**
     * Relationship: State deleted by User
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }
}
