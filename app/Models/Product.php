<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['title','price',"image",'product_code','description'];

    public function package(){ 
        return $this->belongsToMany(Package::class,"product_packages")->withTimestamps();
    }

    public function order(){ 
        return $this->belongsToMany(Package::class,"order_details")->withTimestamps();
    }
}
