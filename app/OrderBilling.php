<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderBilling extends Model
{
    protected $table='order_billing';
    protected $fillable=['order_no','billing_first_name','billing_last_name','billing_country','billing_street_1','billing_street_2','billing_zip','billing_town','billing_email','billing_phone'];
}
