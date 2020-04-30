<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrBrand extends Model
{
    protected $table='pr_brands';
    protected $fillable=['name','brand_desc','slug'];
}
