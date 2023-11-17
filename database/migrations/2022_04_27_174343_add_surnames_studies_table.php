<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSurnamesStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('studies', function (Blueprint $table) {
            $table->string('paternal_surname')->nullable();
            $table->string('maternal_surname')->nullable();
            $table->date('birthday')->nullable();
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
        Schema::table('studies', function (Blueprint $table) {
            $table->dropColumn('paternal_surname');
            $table->dropColumn('maternal_surname');
            $table->dropColumn('birthday');
        });
    }
}
