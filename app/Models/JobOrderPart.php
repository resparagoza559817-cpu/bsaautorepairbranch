<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobOrderPart extends Model
{
    protected $fillable = [
    'job_order_id',
    'part_id',
    'quantity',
    'unit_cost',
    'amount'
    ];

    public $timestamps = false;
}
