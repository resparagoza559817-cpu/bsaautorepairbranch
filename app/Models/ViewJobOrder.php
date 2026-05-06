<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewJobOrder extends Model
{
    protected $table = 'view_job_order';
    
    // Using the actual ID from your new view definition
    protected $primaryKey = 'job_order_id';
    
    public $incrementing = false;
    public $timestamps = false;
}