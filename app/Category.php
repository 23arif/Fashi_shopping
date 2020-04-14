<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table  ='categories';
    protected $fillable =['name','up_category','slug'];

    public function parent(){
        return $this->belongsTo('App\Category', 'up_category');
    }

    public function child(){
        return $this->hasMany('App\Category', 'up_category');
    }

}
