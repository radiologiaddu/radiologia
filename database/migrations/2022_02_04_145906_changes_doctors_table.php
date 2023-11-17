<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangesDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn('color');
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->string('paternalSurname')->after('user_id');
            $table->string('maternalSurname')->after('paternalSurname');
            $table->string('alias')->after('maternalSurname');
            $table->string('title')->after('alias');
            $table->string('phone')->after('title');
            $table->string('color')->nullable();
            $table->dropColumn('status');
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
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn('color');
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn('paternalSurname');
            $table->dropColumn('maternalSurname');
            $table->dropColumn('alias');
            $table->dropColumn('title');
            $table->dropColumn('phone');
            $table->string('status');
            $table->string('color');
        });
    }
}
