<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'order_details';
    protected $fillable = ['order_id',"product_id",'package_id',"product_quantity","package_quantity"];

    public function orderdetail()
    {
        return $this->belongsTo(Order::class);
    }

}
