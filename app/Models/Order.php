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

}
