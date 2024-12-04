<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddObservationsToStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('studies', function (Blueprint $table) {
            $table->text('obs_recep')->nullable()->after('observations'); // Observaciones del recepcionista
            $table->timestamp('date_recep')->nullable()->after('obs_recep'); // Fecha de observación del recepcionista
            $table->text('obs_rad')->nullable()->after('date_recep'); // Observaciones del radiólogo
            $table->timestamp('date_rad')->nullable()->after('obs_rad'); // Fecha de observación del radiólogo
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('studies', function (Blueprint $table) {
            $table->dropColumn(['obs_recep', 'date_recep', 'obs_rad', 'date_rad']);
        });
    }
}
