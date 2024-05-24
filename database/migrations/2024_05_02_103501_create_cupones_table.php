<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuponesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Eliminamos la tabla 'cupons' si ya existe
        Schema::dropIfExists('cupons');

        // Creamos la nueva tabla 'cupones'
        Schema::create('cupones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_doctor')->nullable();
            $table->string('nombre_cupon');
            $table->string('estatus');
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
        Schema::dropIfExists('cupones');
    }
}
