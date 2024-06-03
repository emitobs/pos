<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->char('rut',14)->nullable();
            $table->char('ci',12)->nullable();
            $table->string('socialReasoning')->nullable();
            $table->string('location')->nullable();
            $table->decimal('creditLimit')->nullable();
            $table->string('email')->nullable(); // Agregar campo de correo electrónico
            $table->string('phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('email'); // Eliminar el campo de correo electrónico
            $table->dropColumn('phone');
            $table->dropColumn('rut');
            $table->dropColumn('ci');
            $table->dropColumn('socialReasoning');
            $table->dropColumn('location');
            $table->dropColumn('creditLimit');
        });
    }
}
