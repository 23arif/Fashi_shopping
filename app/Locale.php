<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{
    protected $table = 'locale';
    protected $fillable = ['name','flag'];
}
