<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    protected $table='product_comments';
    protected $fillable=['user_id','product_id','comment','rating'];

    public function getCommentUser(){
        return $this->hasOne('\App\User', 'id', 'user_id');
    }
}
