<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['order_no', 'user_id', 'order_total', 'order_type', 'order_purchase'];

    public function getUserNameFromOrder()
    {
        return $this->hasOne('\App\User', 'id', 'user_id');
    }
}
