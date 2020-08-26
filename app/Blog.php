<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';
    protected $fillable = ['title', 'short_content', 'description', 'author','slug', 'category'];

    public function parent()
    {
        return $this->belongsTo('App\Category', 'category', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'blog', 'slug');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'author');
    }

    public function blogTags()
    {
        return $this->hasMany('App\BlogTags', 'blog_id', 'id');
    }

    public function blogCategory()
    {
        return $this->hasOne('App\Category', 'id', 'category');
    }

}
