<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class,'vendor_id');
    }
}
