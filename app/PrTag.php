<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrTag extends Model
{
    protected $table = 'pr_tags';
    protected $fillable = ['product_id','tag'];
}
