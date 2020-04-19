<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaqTopic extends Model
{
    protected $table = 'faq_topic';
    protected $fillable = ['title', 'content', 'author', 'tags', 'slug', 'prime_title','show_hide'];

    public function primeTitle()
    {
        return $this->hasOne('App\FAQs', 'id', 'prime_title');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'author');
    }

    public function faqComments(){
        return $this->hasMany('App\FaqComment','faq','slug');
    }
}
