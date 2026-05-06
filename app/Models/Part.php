<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    protected $table = 'part'; 
    protected $primaryKey = 'part_id';

    protected $fillable = [
        'part_name',
        'description', 
        'price',
        'stock_qty' 
    ];
}