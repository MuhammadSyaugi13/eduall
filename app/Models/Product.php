<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = 'id';

    public function getPriceAttribute($value)
    {
        // Format the price as US dollars
        return '$' . number_format($value, 2, '.', ',');
    }
}
