<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->increments('id');
            $table->string('name');
            $table->string('description_short')->nullable();
            $table->text('description_long')->nullable();
            $table->double('price', 15, 2);
            $table->double('sale_price', 15, 2)->nullable();
            $table->string('url')->nullable();
            $table->string('cart_url')->nullable();
            $table->string('aff_url')->nullable();
            $table->string('aff_cart_url')->nullable();
            $table->string('images')->nullable();
            $table->string('upc')->index()->nullable();
            $table->string('provider');
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
        Schema::drop('products');
    }
}
