<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Payrollmigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Payrolls', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('dateClosed')->nullable();
            $table->decimal('totalCash', 10, 2)->default(0, 00);
            $table->integer('totalSales')->default(0);
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
        Schema::dropIfExists('Payrolls');
    }
}
