<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table ='blogs';
    protected $fillable =['title','short_content','description','author','tags','slug'];
}
