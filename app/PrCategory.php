<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrCategory extends Model
{
    protected $table='pr_categories';
    protected $fillable=['category_name','category_desc','slug'];
}
