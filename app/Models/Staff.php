<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    // This is the missing piece! 
    // It tells Laravel it's okay to mass-assign these fields.
    protected $fillable = [
        'name',
        'role',
        'contact_number',
    ];
}