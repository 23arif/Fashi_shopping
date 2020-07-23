<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('seller_id');
            $table->string('pr_name');
            $table->text('pr_desc');
            $table->integer('pr_category');
            $table->string('pr_color');
            $table->float('pr_prev_price');
            $table->float('pr_last_price');
            $table->integer('pr_brand');
            $table->integer('pr_size');
            $table->float('pr_weight');
            $table->string('pr_tags');
            $table->integer('pr_sku');
            $table->string('slug');
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
        Schema::dropIfExists('products');
    }
}
