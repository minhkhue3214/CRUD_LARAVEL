<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    //Quy ước đặt tên table
    //Tên Model:package => table:packages
    //Tên Model:product => table:products

    // protected $table = "packages";

    use HasFactory;
    protected $fillable = ['name','description'];

    public function product(){ 
        return $this->belongsToMany(Product::class,"product_packages");
    }
}
