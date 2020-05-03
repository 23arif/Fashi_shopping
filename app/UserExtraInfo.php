<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserExtraInfo extends Model
{
    protected $table='user_extra_info';
    protected $fillable=['user_id','paypal','master_card','visa'];
}
