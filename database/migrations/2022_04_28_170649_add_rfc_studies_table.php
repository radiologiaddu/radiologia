<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRfcStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('studies', function (Blueprint $table) {
            $table->string('rfc')->nullable();
            $table->string('company_name')->nullable();
            $table->string('address')->nullable();
            $table->string('CFDI')->nullable();
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
            $table->dropColumn('rfc');
            $table->dropColumn('company_name');
            $table->dropColumn('address');
            $table->dropColumn('CFDI');
        });
    }
}
