<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table ='blogs';
    protected $fillable =['title','description','author','tags','photo','slug'];
}