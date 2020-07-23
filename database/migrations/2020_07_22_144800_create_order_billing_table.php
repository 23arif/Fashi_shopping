<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderBillingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_billing', function (Blueprint $table) {
            $table->id();
            $table->integer('order_no');
            $table->string('billing_first_name');
            $table->string('billing_last_name');
            $table->string('billing_country');
            $table->string('billing_street_1');
            $table->string('billing_street_2');
            $table->string('billing_zip');
            $table->string('billing_town');
            $table->string('billing_email');
            $table->string('billing_phone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_billing');
    }
}
