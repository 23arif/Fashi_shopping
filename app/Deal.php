<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $table = 'deals';
    protected $fillable  = ['enable_disable','banner','title','desc','price','pr_name','durationDay','durationHourse','durationMinute','durationSeconds','link'];
}
