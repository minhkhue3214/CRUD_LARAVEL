<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id',"user_name",'price'];

    public function user(){ 
        return $this->belongsTo(User::class);
    }

    public function orderdetail()
    {
        return $this->hasMany(OrderDetail::class,"order_id");
    }

    // public function products() {
    //     return $this->hasMany(Product::class);
    // }

    // public function packages()
    // {
    //     return $this->hasMany(Package::class);
    // }

    public function package(){ 
        return $this->belongsToMany(Package::class,"order_details");
    }

    public function product(){ 
        return $this->belongsToMany(Product::class,"order_details");
    }
}
