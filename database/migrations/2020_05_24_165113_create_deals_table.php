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
            $table->integer('enable_disable')->default(0);
            $table->string('banner')->nullable();
            $table->string('title')->nullable();
            $table->text('desc')->nullable();
            $table->float('price')->nullable();
            $table->string('pr_name')->nullable();
            $table->integer('day')->nullable();
            $table->integer('hourse')->nullable();
            $table->integer('minute')->nullable();
            $table->string('second')->nullable();
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
