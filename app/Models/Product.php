<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $guard = [];
 
    public function category(){
        return $this->belongsTo(Category::class);
        
    }
    public function oderDetails(){
        return $this->hasMany(OrderDetail::class, 'product_id', 'id');
    }
}
