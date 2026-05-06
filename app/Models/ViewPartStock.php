<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewPartStock extends Model
{
    protected $table = 'view_part_stock'; // 👈 your view name
    protected $primaryKey = 'part_id';
    public $timestamps = false; // ❗ views don’t use timestamps
}