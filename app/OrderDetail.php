<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table='order_details';
    protected $fillable = ['order_no','pr_id','pr_price','pr_quantity'];
}
