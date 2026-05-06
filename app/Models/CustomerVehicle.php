<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerVehicle extends Model
{
    protected $table = 'view_customer_vehicles';

    protected $primaryKey = 'customer_id';

    public $incrementing = false;

    public $timestamps = false;
}
