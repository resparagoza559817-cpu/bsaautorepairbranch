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
    'category_id',
    'part_name',
    'brand',
    'description', 
    'price',
    'stock_qty',
    'unit_of_measure' 
];

// Relationship to Category
public function category() {
    return $this->belongsTo(Category::class, 'category_id', 'category_id');
}
}