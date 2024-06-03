<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToPaymentsOutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments_out', function (Blueprint $table) {
            $table->string('condition')->nullable();
            $table->bigInteger('credit')->nullable();
            $table->bigInteger('supplier_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments_out', function (Blueprint $table) {
            $table->dropColumn('condition');
            $table->dropColumn('credit');
            $table->dropColumn('supplier_id');
        });
    }
}
