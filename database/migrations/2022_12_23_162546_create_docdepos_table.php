<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocdeposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docdepos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('paternalSurname');
            $table->string('maternalSurname');
            $table->date('birthday');
            $table->string('gender');
            $table->string('phone');
            $table->string('email');
            $table->string('rfc');
            $table->string('specialty');
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
        Schema::dropIfExists('docdepos');
    }
}
