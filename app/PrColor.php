<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrColor extends Model
{
    protected $table='pr_colors';
    protected $fillable=['pr_id','color_name','color_code','slug'];
}
