<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = ['name','blog','email','content','prime_comment','user_id'];

    public function user(){
        return $this->hasOne('App\User','id','user_id');
    }

    public function child(){
        return $this->hasMany('App\Comment', 'prime_comment');
    }


}
