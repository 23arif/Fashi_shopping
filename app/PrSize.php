<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrSize extends Model
{
    protected $table = 'pr_size';
    protected $fillable = ['size','slug'];
}
