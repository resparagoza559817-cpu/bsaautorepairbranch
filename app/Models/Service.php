<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'service_id';

    protected $fillable = [
    'job_desc',
    'price',
    'interval_value',
    'interval_unit'
];
    public function jobOrders()
    {
        return $this->belongsToMany(
            JobOrder::class,
            'job_order_services',
            'service_id',
            'job_order_id'
        );
    }
    
}

