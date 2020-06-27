<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    protected $table = 'basket';
    protected $fillable = ['user_id','product_id','quantity'];

    protected function getProductInfo(){
        return $this->hasOne('App\Product','id','product_id');
    }
}
