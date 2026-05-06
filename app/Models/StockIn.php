<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;

    protected $table = 'stock_ins'; 
    protected $primaryKey = 'id';

    protected $fillable = [
        'part_id',
        'supplier_id',
        'quantity_received',
        'cost_per_unit',
        'stock_in_arrived'
    ];

    public function part()
    {
        return $this->belongsTo(Part::class, 'part_id', 'part_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }
}