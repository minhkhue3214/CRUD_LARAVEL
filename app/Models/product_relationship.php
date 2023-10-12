<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_relationship extends Model
{
    use HasFactory;
    protected $fillable = ['_token', 'product_id','product_package_id'];
}
