<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicle';
    protected $primaryKey = 'vehicle_id'; // Important for matching your DB[cite: 5]

    protected $fillable = [
        'plate_number',
        'make',
        'engine_model', // Matches DB column name[cite: 5]
        'customer_id'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}