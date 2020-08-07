<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'profile_image', 'name', 'surname', 'phone', 'email', 'password', 'slug','status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

//    Function for check users status.Is user admin or not?
    public function status()
    {
        return $this->status;
    }

    public function countProduct()
    {
        return $this->hasMany('\App\Product', 'seller_id', 'id');
    }

    public function countBlogComment()
    {
        return $this->hasMany('\App\Comment', 'user_id', 'id');
    }

    public function countBlog()
    {
        return $this->hasMany('\App\Blog', 'author', 'id');
    }

    public function faqQuestions()
    {
        return $this->hasMany('\App\FaqTopic', 'author', 'id');
    }

    public function faqComments()
    {
        return $this->hasMany('\App\FaqComment', 'user_id', 'id');
    }
}
