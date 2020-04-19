<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaqComment extends Model
{
    protected $table = 'faq_comments';
    protected $fillable = ['primary_comment','user_id','faq','faq_content'];

    public function faqTopic(){
        return $this->hasOne('App\FaqTopic','id','faq');
    }
    public function commentOwner(){
        return $this->hasOne('App\User','id','user_id');
    }
    public function primaryComment(){
        return $this->hasMany('App\FaqComment','primary_comment');
    }
}
