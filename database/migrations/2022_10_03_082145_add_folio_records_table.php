<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Record;
use App\Models\Study;

class AddFolioRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('records', function (Blueprint $table) {
            $table->text('folio')->nullable();
        });

        $records = Record::all();
        foreach($records as $record){
            $study = Study::where('folio',$record->study_id)->first();
            $record->folio = $record->study_id;
            $record->save();
            if(!is_null($study)){
                $record->study_id = $study->id;
                $record->save();
            }
            
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $records = Record::all();
        foreach($records as $record){
            $study = Study::where('id',$record->study_id)->first();
            $record->study_id = $study->folio;
            $record->save();
            
        }
        Schema::table('records', function (Blueprint $table) {
            $table->dropColumn('folio');
        }); 
    }
}
