<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['seller_id', 'pr_name', 'pr_desc', 'pr_category', 'pr_color', 'pr_prev_price', 'pr_last_price', 'pr_brand', 'pr_size', 'pr_weight', 'pr_tags', 'pr_sku', 'slug'];

    public function prColor()
    {
        return $this->hasOne('App\PrColor', 'id', 'pr_color');
    }

    public function prBrand()
    {
        return $this->hasOne('App\PrBrand', 'id', 'pr_brand');
    }

    public function prSize()
    {
        return $this->hasOne('App\PrSize', 'id', 'pr_size');
    }

    public function sellerName()
    {
        return $this->hasOne('App\User', 'id', 'seller_id');
    }

    public function prCategory()
    {
        return $this->hasOne('App\PrCategory', 'id', 'pr_category');
    }
}
