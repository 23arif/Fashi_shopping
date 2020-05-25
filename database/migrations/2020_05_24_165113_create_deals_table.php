<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->integer('enable_disable');
            $table->string('banner');
            $table->string('title');
            $table->text('desc');
            $table->float('price');
            $table->string('pr_name');
            $table->integer('day');
            $table->integer('hourse');
            $table->integer('minute');
            $table->string('second');
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
        Schema::dropIfExists('deals');
    }
}
