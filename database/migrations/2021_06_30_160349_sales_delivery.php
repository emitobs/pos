<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SalesDelivery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_delivery', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', 10, 2);
            $table->foreignId('delivery_id')->constrained();
            $table->foreignId('sale_id')->constrained();
            $table->foreignId('payroll_id')->constrained();
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
        //
    }
}
