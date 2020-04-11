<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';
    protected $fillable = ['logo','url','title','description','keywords','author','phone','gsm','faks','mail','address','recapctha','map','analystic','facebook','twitter','instagram','youtube','smtp_user','smtp_password','smtp_host','smtp_port'];
}