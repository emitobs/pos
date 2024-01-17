<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductsVariety extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variety', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id'); // Esto crea una relación con el producto
            $table->string('name'); // Nombre de la variedad (ej. Coca, Sprite, Fanta)
            $table->decimal('price', 10, 2); // Precio de la variedad
            $table->integer('stock');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

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
        Schema::dropIfExists('variety');
    }
}
