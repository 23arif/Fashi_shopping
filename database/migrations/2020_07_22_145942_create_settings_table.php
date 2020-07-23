<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo');
            $table->integer('slider');
            $table->string('url');
            $table->string('title');
            $table->text('description');
            $table->string('keywords');
            $table->integer('author');
            $table->string('phone');
            $table->string('gsm');
            $table->string('faks');
            $table->string('mail');
            $table->string('address');
            $table->string('recapctha');
            $table->string('map');
            $table->string('analystic');
            $table->string('facebook');
            $table->string('twitter');
            $table->string('instagram');
            $table->string('youtube');
            $table->string('smtp_user');
            $table->string('smtp_password');
            $table->string('smtp_host');
            $table->string('smtp_port');
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
        Schema::dropIfExists('settings');
    }
}
