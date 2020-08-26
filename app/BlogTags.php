<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogTags extends Model
{
    protected $fillable=['blog_id','tag','slug'];
}
