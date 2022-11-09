<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];
    protected $table = 'customers';
    protected $fillable=[
        'name','avatar','phone','email','password'
    ];
    function orders(){
        return $this->hasMany(Order::class);
    }
}
