<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class Customer extends Model
{
    protected $table = 'customer';

    protected $fillable = [
    'cust_name',
    'contact_number',
    'address'
    ];
}
