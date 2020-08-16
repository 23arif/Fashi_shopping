<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactComment extends Model
{
    protected $table = 'contact_comments';
    protected $fillable = ['name', 'email', 'message', 'check_message','slug'];

}
