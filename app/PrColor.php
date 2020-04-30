<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrColor extends Model
{
    protected $table='pr_colors';
    protected $fillable=['color_name','color_code'];
}
