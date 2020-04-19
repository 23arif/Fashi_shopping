<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FAQs extends Model
{
    protected $table = 'faqs';
    protected $fillable = ['name', 'short_content', 'slug'];

    public function faqTitle()
    {
        return $this->hasMany('App\FaqTopic', 'prime_title', 'id');
    }
}
