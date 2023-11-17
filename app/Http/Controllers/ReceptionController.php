<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Study;
use App\Models\Study_type;
use App\Models\Question;
use App\Models\Type_question;
use App\Models\CFDI;
use App\Models\Tax;
use App\Models\Discount;
use Illuminate\Support\Facades\Mail;
use App\Mail\mailStudy;
use App\Models\Record;
use Carbon\Carbon;
use App\Models\Type;
use App\Models\Question_answer;
use App\Models\Answer;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Referral;
use App\Mail\newStudy;
use App\Events\hostEvent;
use App\Events\cashEvent;

class ReceptionController extends Controller
{

    public function index()
    {
        set_time_limit(0);
               
        $studies = Study::with('appointment','doctor','study_type.type')->where('status','Llegada')->orWhere('status','Caja')->orWhere('status','Pagado')->orWhere('status','Realizado')->orWhere('status','Empezado')->orderBy('created_at', 'DESC')->get();
        $vA = session('flagModalR');
        return view('dashboardReception',compact('studies','vA'));
    }
    public function indexReload()
    {
        set_time_limit(0);

        $studies = Study::with('appointment','doctor')->where('status','Llegada')->orWhere('status','Caja')->orWhere('status','Pagado')->orWhere('status','Realizado')->orWhere('status','Empezado')->orderBy('created_at', 'DESC')->get();
        $weekMap = [
            0 => 'Dom',
            1 => 'Lun',
            2 => 'Mar',
            3 => 'Mie',
            4 => 'Jue',
            5 => 'Vie',
            6 => 'Sáb',
        ];
        $months = [
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
        ];
        $opciones = '
        <table id="zero-configurationo" class="display table nowrap table-striped table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th class="tMovil">Folio</th>
                    <th class="tMovil">Folio SAE</th>
                    <th>Paciente</th>
                    <th>Estudio</th>
                    <th class="tMovil">Estatus</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>';
                foreach ($studies as $study){
                $opciones .= '
                <tr>
                    <td>'.$study->id.'</td>
                    <td class="tMovil">';
                    if ($study->internal == 1){
                        $opciones .='R'.sprintf('%06d',$study->folio);
                    }else{
                        $opciones .='D'.sprintf('%06d',$study->folio);
                    }
                    $opciones .='</td>
                    <td class="tMovil">'.$study->sae.'</td>
                    <td>'.$study->patient_name.' '.$study->paternal_surname.' '.$study->maternal_surname.'</td>
                    <td>';
                    if($study->study_type->count() > 0){
                        $opciones .=$study->study_type[0]->type->type;
                    }
                    $opciones .= '
                    </td>
                    <td class="tMovil">'.$study->status.'</td>
                    <td>';
                        if ($study->status == "Realizado"){
                            $opciones .= '
                            <a href="'.route('sendStudy',['id' => $study->id]).'" class="label theme-bg2 f-12 text-white btn-rounded borrar" title="ENVIAR"><i class="feather icon-mail mr-0"></i></a>
                                
                            <a href="'.route('historialRec',['id' => $study->id]).'"title="HISTORIAL" class="label theme-record text-white f-12 btn-rounded" ><i class="feather icon-folder mr-0"></i></a>';
                        }else{
                            $opciones .= '
                            <a href="'.route('showStudyRecep',['id' => $study->id]).'"title="VER" class="label theme-bg text-white f-12 btn-rounded"><i class="feather icon-eye mr-0"></i></a>';
                        }
                        if ($study->status != "Llegada"){
                            $opciones .= '
                            <div id="modal'.$study->id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal'.$study->id.'Title" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modal'.$study->id.'Title">Folio SAE:</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">FOLIO SAE:</label>
                                                    <input id="'.$study->id.'SAE" class="form-control" placeholder="FOLIO" type="text" name="'.$study->id.'SAE" value="'.$study->sae.'" required>
                                                </div>        
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            <button id="'.$study->id.'" type="button" class="btn btn-primary folio" data-dismiss="modal">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a title="FOLIO" class="label theme-folio f-12 btn-rounded" data-toggle="modal" data-target="#modal'.$study->id.'"><i class="fas fa-file-alt mr-0"></i></button>
                        ';
                        }
                    $opciones .= '
                    </td>
                </tr>';
                }
            $opciones .= '
            </tbody>
        </table>';
        
        return $opciones;      
    }
    
    public function sendStudy($id = null)
    {
        set_time_limit(0);

        if(is_null($id)){
            $study = null;
            $studies = Study::where('status', 'Realizado')->select('id','folio','patient_name','paternal_surname','maternal_surname','internal')->with('study_type.type')->orderBy('created_at', 'DESC')->get();
        }else{
            $study = Study::where('status', 'Realizado')->with('appointment','doctor')->findOrFail($id);
            $studies = null;
        }
        return view('sendStudy',compact('study','studies'));
    }

    public function sendEmailStudy(Request $request, $id = null)
    {
        set_time_limit(0);

        if(is_null($id)){
            $study = Study::where('status', 'Realizado')->with('appointment','doctor')->findOrFail($request->selectStudy);
        }else{
            $study = Study::where('status', 'Realizado')->with('appointment','doctor')->findOrFail($id);
        }
        $file = $request->file('images');
        if($file == null){
            $file = [];
        }
        $link = $request->link;
        Mail::to($study->patient_email)->send(new mailStudy($file,$study,$link));
        if($study->doctor_id != 0 ){
            Mail::to($study->doctor->user->email)->send(new mailStudy($file,$study,$link));
        }else{
            Mail::to($study->doctor_email)->send(new mailStudy($file,$study,$link));
        }

        $study->status = 'Enviado';
        $study->save();
        $newRecord = Record::create([
            'study_id' => $study->id,
            'action' => "Se enviaron los estudios al correo del paciente y del doctor.",
            'user' => auth()->user()->name,
            'user_email' => auth()->user()->email,
            'folio' => $study->folio,
        ]);
        session(['flagModalR' => true]);
        
        return redirect()->route('recepcion') ;
    }
    
    public function finish ($id)
    {
        $study = Study::with('appointment','doctor')->findOrFail($id);

        $study->status = 'Enviado';
        $study->save();
        $file = [];
        $link = null;
        Mail::to($study->patient_email)->send(new mailStudy($file,$study,$link));
        if($study->doctor_id != 0){
            Mail::to($study->doctor->user->email)->send(new mailStudy($file,$study,$link));
        }
        $newRecord = Record::create([
            'study_id' => $study->id,
            'action' => "Estudio finalizado, NO se ha enviado por correo los estudios.",
            'user' => auth()->user()->name,
            'user_email' => auth()->user()->email,
            'folio' => $study->folio,
        ]);
        return true;

    }
    public function getStudy(Request $request)
    {
        set_time_limit(0);

        $study = Study::with('appointment','doctor')->findOrFail($request->id);
        $opciones = "";
        $opciones .='<div class="col-12 col-md-6">
                        <h6 class="col-12">
                            Folio: ';
                            if ($study->internal == 1){
                                $opciones .='R'.sprintf('%06d',$study->folio);
                            }else{
                                $opciones .='D'.sprintf('%06d',$study->folio);
                            }
                        $opciones .=
                        '</h6>
                        <h6 class="col-12">
                            Doctor: ';
                            if ($study->doctor_id == 0){
                                $opciones .='<div id="reloadDrName" value="false" class="col-12">'.$study->doctor_name.'</div>';
                            }else{
                                $opciones .='<div id="reloadDrName" value="true" class="col-12">'.$study->doctor->alias.'</div>';
                            }
                            $opciones .='
                        </h6>
                        <h6 class="col-12">
                            Cita:
        ';
        if(isset($study->appointment)){
            $weekMap = [
                0 => 'domingo',
                1 => 'lunes',
                2 => 'martes',
                3 => 'miércoles',
                4 => 'jueves',
                5 => 'viernes',
                6 => 'sábado',
            ];
            $months = [
                '01' => 'Enero',
                '02' => 'Febrero',
                '03' => 'Marzo',
                '04' => 'Abril',
                '05' => 'Mayo',
                '06' => 'Junio',
                '07' => 'Julio',
                '08' => 'Agosto',
                '09' => 'Septiembre',
                '10' => 'Octubre',
                '11' => 'Noviembre',
                '12' => 'Diciembre',
            ];
            $opciones .=$weekMap[strftime("%w",strtotime($study->appointment->date))].strftime("%d",strtotime($study->appointment->date)).strtoupper($months[strftime("%m",strtotime($study->appointment->date))]).strftime("%Y",strtotime($study->appointment->date));
            $opciones .=' hrs.<br>'.$study->appointment->time;
        }else{
            $opciones .='Sin agendar cita';
        }
        $opciones .=' </h6>
                    </div>
                    <div class="col-12 col-md-6">
                        <h5 class="col-12">
                            DATOS DEL PACIENTE
                        </h5>
                        <h6 class="col-12">'.
                            $study->patient_name.'
                        </h6>
                        <h6 class="col-12">'.
                            $study->patient_email.'
                        </h6>
                        <h6 class="col-12">'.
                            $study->patient_phone.'
                        </h6>
                    </div>';

        return $opciones;     
    }

    public function editRecepcion($id)
    {
        $study = Study::findOrFail($id);
        $types = Type::orderBy('id')->get();
        $mytime = Carbon::now()->timezone("America/Mexico_City");
        $referrals = Referral::all();
        $year = strftime("%Y",strtotime($mytime->toDateString()));
        $arrayStudies = [];
        foreach($study->study_type as $study_type){
            $arrayQuestions = [];
            $type = $study_type->type;
            
            foreach($type->questions as $question){
                $arrayAnswer = [];
                $type_question = $study_type->type_question->where('question_id',$question->id)->first();
                if(isset($type_question)){
                    if($question->kind == "texto"){
                        array_push($arrayAnswer,$type_question->answer);
                    }else{
                        /*
                        $question_answers = Question_answer::where('')->get();
                        foreach($question_answers as $question_answer){
                            $answer = $question_answer->answer;
                            array_push($arrayAnswer,$answer->answer);
                        }*/
                        foreach($type_question->question_answer as $question_answer){
                            array_push($arrayAnswer,$question_answer->answer_id);
                        }
                    }
                }
                
                $objQuestion = $question;
                $objQuestion->answers = $arrayAnswer;
                array_push($arrayQuestions,$objQuestion);
            }
            

            /*
            foreach($study_type->type_question as $type_question){
                $arrayAnswer = [];
                $question = $type_question->question;
                if($question->kind == "texto"){
                    array_push($arrayAnswer,$type_question->answer);
                }else{
                    foreach($type_question->question_answer as $question_answer){
                        $answer = $question_answer->answer;
                        array_push($arrayAnswer,$answer->answer);
                    }
                }
                $objQuestion = (object)[
                    'question' => $question->question,
                    'answers' => $arrayAnswer,
                ];
                array_push($arrayQuestions,$objQuestion);
            }  
            */
            $objStudy = (object)[
                'oldId' => $study_type->id,
                'id' => $type->id,
                'title' => $type->type,
                'questions' => $arrayQuestions,
                'note' => $type->note,
                'class_note' => $type->class_note,
            ];
        
            array_push($arrayStudies,$objStudy);
        }
        $vA = session('flagModalChange');

        return view('editReception',compact('study','arrayStudies','year','types','vA','referrals'));
    }

    
    public function updateStudy(Request $request, $id)
    {
        $study = Study::findOrFail($id);
        $study->patient_name = $request->patient_name;
        $study->patient_email = $request->patient_email;
        $study->patient_phone = $request->patient_phone;
        $study->observations = $request->note;
        $study->paternal_surname = $request->paternal_surname;
        $study->maternal_surname = $request->maternal_surname;
        $study->birthday = $request->year."-".$request->month."-".$request->day;
        $study->total = $request->total;
        $study->duration = $request->duration;

        foreach($study->study_type as $study_type){
            if (!in_array("old".$study_type->id, $request->arrayTypeOld)) {
                foreach($study_type->type_question as $question){
                    foreach($question->question_answer as $answer){
                        $answer->delete();
                    }
                    $question->delete();
                }
                $study_type->delete();
            }else{

                if(request("old".$study_type->id) == $study_type->type_id){

                }else{
                    $study_type->type_id = request("old".$study_type->id);
                    $study_type->save();                    
                }
                
                $newStudy_type = $study_type;
                foreach($study_type->type_question as $question){
                    foreach($question->question_answer as $answer){
                        $answer->delete();
                    }
                    $question->delete();
                }

                if(!is_null(request("old".$study_type->id.'question'))){
                    foreach (request("old".$study_type->id.'question') as $question_id) {
                        if(!is_null(request("old".$study_type->id.'question'.$question_id))){
                            $findQuestion = Question::findOrFail($question_id);
                            if($findQuestion->kind == "texto"){
    
                                $newType_question = Type_question::create([
                                    's_t_id' => $newStudy_type->id,
                                    'question_id' => $question_id,
                                    'answer' => request("old".$study_type->id.'question'.$question_id)
                                ]);
                            }else{
                                $newType_question = Type_question::create([
                                    's_t_id' => $newStudy_type->id,
                                    'question_id' => $question_id,
                                ]);
                                //$newType_question->id
                                if($findQuestion->kind == "radio"){
                                    if($findQuestion->answer()->count() > 1){
                                        $newQuestion_answer = Question_answer::create([
                                            't_q_id' => $newType_question->id,
                                            'answer_id' => request("old".$study_type->id.'question'.$question_id),
                                        ]);
                                        $findAnswer = Answer::findOrFail($newQuestion_answer->answer_id);
                                        if($study->internal){
                                            $newQuestion_answer->cost = $findAnswer->cost;
                                        }else{
                                            $newQuestion_answer->cost = $findAnswer->costDoctor;
                                        }
                                        $newQuestion_answer->save();
                                    }else{
                                        foreach (request("old".$study_type->id.'question'.$question_id) as $answer_id) {
                                            $newQuestion_answer = Question_answer::create([
                                                't_q_id' => $newType_question->id,
                                                'answer_id' => $answer_id,
                                            ]);
                                            $findAnswer = Answer::findOrFail($newQuestion_answer->answer_id);
                                            if($study->internal){
                                                $newQuestion_answer->cost = $findAnswer->cost;
                                            }else{
                                                $newQuestion_answer->cost = $findAnswer->costDoctor;
                                            }
                                            $newQuestion_answer->save();
                                        }
                                    }
                                    
                                }else{
                                    foreach (request("old".$study_type->id.'question'.$question_id) as $answer_id) {
                                        $newQuestion_answer = Question_answer::create([
                                            't_q_id' => $newType_question->id,
                                            'answer_id' => $answer_id,
                                        ]);
                                        $findAnswer = Answer::findOrFail($newQuestion_answer->answer_id);
                                        if($study->internal){
                                            $newQuestion_answer->cost = $findAnswer->cost;
                                        }else{
                                            $newQuestion_answer->cost = $findAnswer->costDoctor;
                                        }
                                        $newQuestion_answer->save();
                                    }
                                }
                                
                            }
                        }
                    }    
                }
                
            }

        }

        $study->save();

        if(isset($request->arrayType)){
            foreach ($request->arrayType as $arrayType) {

                $newStudy_type = Study_type::create([
                    'study_id' => $study->id,
                    'type_id' => request($arrayType),
                ]);

                //$newStudy_type->id
                if(!is_null(request($arrayType.'question'))){
                    foreach (request($arrayType.'question') as $question_id) {
                        if(!is_null(request($arrayType.'question'.$question_id))){
                            $findQuestion = Question::findOrFail($question_id);
                            if($findQuestion->kind == "texto"){

                                $newType_question = Type_question::create([
                                    's_t_id' => $newStudy_type->id,
                                    'question_id' => $question_id,
                                    'answer' => request($arrayType.'question'.$question_id)
                                ]);
                            }else{
                                $newType_question = Type_question::create([
                                    's_t_id' => $newStudy_type->id,
                                    'question_id' => $question_id,
                                ]);
                                //$newType_question->id
                                if($findQuestion->kind == "radio"){
                                    if($findQuestion->answer()->count() > 1){
                                        $newQuestion_answer = Question_answer::create([
                                            't_q_id' => $newType_question->id,
                                            'answer_id' => request($arrayType.'question'.$question_id),
                                        ]);
                                        $findAnswer = Answer::findOrFail($newQuestion_answer->answer_id);
                                        if($study->internal){
                                            $newQuestion_answer->cost = $findAnswer->cost;
                                        }else{
                                            $newQuestion_answer->cost = $findAnswer->costDoctor;
                                        }
                                        $newQuestion_answer->save();
                                    }else{
                                        foreach (request($arrayType.'question'.$question_id) as $answer_id) {
                                            $newQuestion_answer = Question_answer::create([
                                                't_q_id' => $newType_question->id,
                                                'answer_id' => $answer_id,
                                            ]);
                                            $findAnswer = Answer::findOrFail($newQuestion_answer->answer_id);
                                            if($study->internal){
                                                $newQuestion_answer->cost = $findAnswer->cost;
                                            }else{
                                                $newQuestion_answer->cost = $findAnswer->costDoctor;
                                            }
                                            $newQuestion_answer->save();
                                        }
                                    }
                                    
                                }else{
                                    foreach (request($arrayType.'question'.$question_id) as $answer_id) {
                                        $newQuestion_answer = Question_answer::create([
                                            't_q_id' => $newType_question->id,
                                            'answer_id' => $answer_id,
                                        ]);
                                        $findAnswer = Answer::findOrFail($newQuestion_answer->answer_id);
                                        if($study->internal){
                                            $newQuestion_answer->cost = $findAnswer->cost;
                                        }else{
                                            $newQuestion_answer->cost = $findAnswer->costDoctor;
                                        }
                                        $newQuestion_answer->save();
                                    }
                                }
                                
                            }
                        }
                    }    
                }
            }
        }
        $newRecord = Record::create([
            'study_id' => $study->id,
            'action' => "Cambio en los datos del estudio.",
            'user' => auth()->user()->name,
            'user_email' => auth()->user()->email,
            'folio' => $study->folio,
        ]);

        session(['flagModalChange' => true]);
        return redirect()->route('showStudyRecep',['id' => $study->id]);
    }

    public function folio(Request $request, $id)
    {
        $study = Study::findOrFail($id);
        $study->sae = $request->sae;
        $study->save();
        return 200;     
    }

    public function question(Request $request)
    {
        $type = Type::with('questions')->findOrFail($request->id);
        $opciones = "";
        foreach($type->questions as $question){
            $opciones .= '<div class="form-group col-12 p-0 mb-0 text-left">
                            <div class="title-block">
                                <input name="'.$request->idElement.'question[]" type="hidden" value="'.$question->id.'">
                                <h6 class="title'.$request->idElement.'" id="question'.$question->id.'">'.$question->question.'</h6>
                            </div>
                        </div>';
            if($question->kind == "radio"){
                if(count($question->answer)>1){
                    foreach($question->answer as $answer){
                        if($answer->answer == "11" || $answer->answer == "21"){
                            $opciones .='<div class="col-6">';
                        }
                        if($answer->answer == "31" || $answer->answer == "41"){
                            $opciones .='<div class="col-6 mt-4">';
                        }
                        $labelCost = '';
                        $cost = 0;
                        if(isset($request->internal)){
                            if ($request->internal == 0){
                                $answerCost = $answer->costDoctor;
                            }else{
                                $answerCost = $answer->cost;
                            }
                        }else{
                            $answerCost = $answer->cost;
                        }
                        if(!is_null($answerCost)){
                            $labelCost = ' ('.sprintf('$ %s', number_format($answerCost, 2)).')';
                            $cost = $answerCost;
                        }
                        $opciones .='<div class="form-check col-12 pl-5">
                                        <input study_time="'.$answer->study_time.'" preparation_time="'.$answer->preparation_time.'" exit_time="'.$answer->exit_time.'" cost="'.$cost.'"';
                                        if(count($answer->dependency)>0){
                                            $opciones .= 'class="dependency ';
                                            foreach($answer->dependency as $dependency){
                                                $opciones .= $request->idElement.'question'.$dependency->question_id;
                                            }
                                        }else{
                                            $opciones .= 'class="';
                                        }
                                        $opciones .= ' form-check-input answer-input'.$request->idElement.'" type="radio" name="'.$request->idElement.'question'.$question->id.'" value="'.$answer->id.'" data-name="'.$answer->answer.'">
                                        <label class="form-check-label" for="'.$request->idElement.'question'.$question->id.'" style="font-size: 14px;">'.$answer->answer.$labelCost.'</label>
                                    </div>';
                        if($answer->answer == "18" || $answer->answer == "28" || $answer->answer == "38" || $answer->answer == "48"){
                            $opciones .='</div>';
                        }
                    }
                    
                }else{
                    foreach($question->answer as $answer){
                        $labelCost = '';
                        $cost = 0;
                        if(isset($request->internal)){
                            if ($request->internal == 0){
                                $answerCost = $answer->costDoctor;
                            }else{
                                $answerCost = $answer->cost;
                            }
                        }else{
                            $answerCost = $answer->cost;
                        }
                        if(!is_null($answerCost)){
                            $labelCost = ' ('.sprintf('$ %s', number_format($answerCost, 2)).')';
                            $cost = $answerCost;
                        }
                        $opciones .='<div class="custom-control custom-checkbox col-12 pl-5">
                                        <input study_time="'.$answer->study_time.'" preparation_time="'.$answer->preparation_time.'" exit_time="'.$answer->exit_time.'" cost="'.$cost.'"';
                                        if(count($answer->dependency)>0){
                                            $opciones .= 'disabled class="dependency ';
                                            foreach($answer->dependency as $dependency){
                                                $opciones .= $request->idElement.'question'.$dependency->question_id;
                                            }
                                        }else{
                                            $opciones .= 'class="';
                                        }
                                        $opciones .= ' custom-control-input answer-input'.$request->idElement.'" type="checkbox" id="element'.$request->idElement.'question'.$question->id.'answer'.$answer->id.'" name="'.$request->idElement.'question'.$question->id.'[]" value="'.$answer->id.'">
                                        <label class="custom-control-label" for="element'.$request->idElement.'question'.$question->id.'answer'.$answer->id.'" style="font-size: 14px;">'.$answer->answer.$labelCost.'</label>
                                </div>';
                    }
                }
            }elseif ($question->kind == "check"){
                foreach($question->answer as $answer){
                    if($answer->answer == "11" || $answer->answer == "21"){
                        $opciones .='<div class="col-6">';
                    }
                    if($answer->answer == "31" || $answer->answer == "41"){
                        $opciones .='<div class="col-6 mt-4">';
                    }
                    $labelCost = '';
                    $cost = 0;
                    if(isset($request->internal)){
                        if ($request->internal == 0){
                            $answerCost = $answer->costDoctor;
                        }else{
                            $answerCost = $answer->cost;
                        }
                    }else{
                        $answerCost = $answer->cost;
                    }
                    if(!is_null($answerCost)){
                        $labelCost = ' ('.sprintf('$ %s', number_format($answerCost, 2)).')';
                        $cost = $answerCost;
                    }
                    $opciones .='<div class="custom-control custom-checkbox col-12 pl-5">
                                    <input study_time="'.$answer->study_time.'" preparation_time="'.$answer->preparation_time.'" exit_time="'.$answer->exit_time.'" cost="'.$cost.'"';
                                    if(count($answer->dependency)>0){
                                        $opciones .= 'class="dependency ';
                                        foreach($answer->dependency as $dependency){
                                            $opciones .= $request->idElement.'question'.$dependency->question_id;
                                        }
                                    }else{
                                        $opciones .= 'class="';
                                    }
                                    $opciones .= ' custom-control-input answer-input'.$request->idElement.'" type="checkbox" id="element'.$request->idElement.'question'.$question->id.'answer'.$answer->id.'" name="'.$request->idElement.'question'.$question->id.'[]" value="'.$answer->id.'">
                                    <label class="custom-control-label" for="element'.$request->idElement.'question'.$question->id.'answer'.$answer->id.'" style="font-size: 14px;">'.$answer->answer.$labelCost.'</label>
                                </div>';
                    if($answer->answer == "18" || $answer->answer == "28" || $answer->answer == "38" || $answer->answer == "48"){
                        $opciones .='</div>';
                    }
                }
            }else{
                $opciones .='<div class="form-group">
                                <div class="input-group">
                                    <input name="'.$request->idElement.'question'.$question->id.'" type="text"';
                                    if(count($question->dependency)>0){
                                        $opciones .= 'disabled class="dependent';
                                    }else{
                                        $opciones .= 'class="';
                                    }
                                    $opciones .= ' form-control answer answer-input'.$request->idElement.'" placeholder="Respuesta">
                                </div>
                            </div>';
            }
            
            if(!is_null($question->class_note)){
                $opciones .='<div class="col-12">';

                if($question->class_note == "simpleNote"){
                    $opciones .='<div class="form-group">
                                    <label class="form-check-label" for="simpleNote" style="font-size: 14px;">'.nl2br($question->note).'</label>
                                </div>';
                }else{
                    $opciones .='<div class="form-group">
                                        <label class="form-check-label" for="highlightedNote" style="font-size: 14px;">
                                        <div style="background: rgb(110,123,222);
                                        border-radius: 50%;
                                        height: 30px;
                                        width: 30px;
                                        text-align: center;
                                        align-items: center;
                                        display: flex;
                                        float: left;">
                                            <img src="'.asset("/image/blanco100.png").'" style="width: 20px;
                                            height: 20px;
                                            margin-left: auto;
                                            margin-right: auto;" alt="User-Profile-Image">
                                        </div>
                                        <span style="background: rgb(110,123,222);
                                        color: white;
                                        font-size: 16px;
                                        margin-left: 5px;
                                        padding: 5px;
                                        align-items: center;
                                        display: flex;">
                                        '.nl2br($question->note).'
                                        </span>
                                        <div class="clearfix"></div>
    
                                    </label>
                                </div>';
                }
                $opciones .='</div>';
            }

        }
        
        if(!is_null($type->class_note)){
            if($type->class_note == "simpleNote"){
                $opciones .='<div class="form-group mt-3 col-12">
                                <label class="form-check-label" for="simpleNote" style="font-size: 14px;">'.nl2br($type->note).'</label>
                            </div>';
            }else{
                $opciones .='<div class="form-group mt-3 col-12">
                                    <label class="form-check-label" for="highlightedNote" style="font-size: 14px;">
                                    <div style="background: rgb(110,123,222);
                                    border-radius: 50%;
                                    height: 30px;
                                    width: 30px;
                                    text-align: center;
                                    align-items: center;
                                    display: flex;
                                    float: left;">
                                        <img src="'.asset("/image/blanco100.png").'" style="width: 20px;
                                        height: 20px;
                                        margin-left: auto;
                                        margin-right: auto;" alt="User-Profile-Image">
                                    </div>
                                    <span style="background: rgb(110,123,222);
                                    color: white;
                                    font-size: 16px;
                                    margin-left: 5px;
                                    padding: 5px;
                                    align-items: center;
                                    display: flex;">
                                    '.nl2br($type->note).'
                                    </span>
                                    <div class="clearfix"></div>

                                </label>
                            </div>';
            }
            

        }
        
        return $opciones;     
    }

    public function show($id)
    {
        $study = Study::with('appointment','doctor')->findOrFail($id);
        $cfdis = CFDI::all();
        $taxes = Tax::all();
        $discounts = Discount::all();
        $arrayStudies = [];
        foreach($study->study_type as $study_type){
            $arrayQuestions = [];
            $type = $study_type->type;
            foreach($study_type->type_question as $type_question){
                $arrayAnswer = [];
                $question = $type_question->question;
                if($question->kind == "texto"){
                    array_push($arrayAnswer,$type_question->answer);
                }else{
                    foreach($type_question->question_answer as $question_answer){
                        $answer = $question_answer->answer;
                        array_push($arrayAnswer,$answer->answer);
                    }
                }
                $objQuestion = (object)[
                    'question' => $question->question,
                    'class_note' => $question->class_note,
                    'note' => $question->note,
                    'answers' => $arrayAnswer,
                ];
                array_push($arrayQuestions,$objQuestion);
            }  
            $objStudy = (object)[
                'title' => $type->type,
                'questions' => $arrayQuestions,
                'note' => $type->note,
                'class_note' => $type->class_note,
            ];
        
            array_push($arrayStudies,$objStudy);
        }

        $vA = session('flagModalChange');
        session()->forget('flagModalChange');

        return view('showStudyRec',compact('study','arrayStudies','cfdis','taxes','vA','discounts'));
    }
    

    public function cashier(Request $request)
    {
        $id = $request->id;
        $study = Study::where('qr',$id)->first();
        if(isset($request->discount)){
            if($request->discount == 0){
                $id_discount = 0;
                $percentage = 0;
            }else{
                $discount = Discount::findOrFail($request->discount);
                $id_discount = $request->discount;
                $percentage = $discount->percentage;
            }
        }else{
            $id_discount = null;
            $percentage = null;
        }
        if($study->status == 'Llegada'){
            $study->status = 'Caja';
            $study->id_discount = $id_discount;
            $study->discount = $percentage;
            $study->save();
            $newRecord = Record::create([
                'study_id' => $study->id,
                'action' => "Indicó que el cliente pasó a caja.",
                'user' => auth()->user()->name,
                'user_email' => auth()->user()->email,
                'folio' => $study->folio,
            ]);
            event(new cashEvent());

            return true;
        }
        return false;
    }

    public function addInvoice(Request $request, $id)
    { 
        $study = Study::findOrFail($id);
        $study->rfc  = strtoupper($request->rfc);
        $study->company_name  = strtoupper($request->razon);
        $study->address  = "No requerida";
        $study->CFDI  = $request->cfdi;
        $study->tax  = $request->tax;
        $study->cp  = $request->cp;
        $study->save();
        $newRecord = Record::create([
            'study_id' => $study->id,
            'action' => "Se agregaron los datos para la factura",
            'user' => auth()->user()->name,
            'user_email' => auth()->user()->email,
            'folio' => $study->folio,
        ]);
        return redirect()->route('showStudyRecep', $study->id);
    }

    public function create()
    {
        $doctors = User::Role(['Doctor'])->with('doctor')->orderBy('id')->where('email_verified_at','!=',null)->get();
        $types = Type::orderBy('id')->get();
        $mytime = Carbon::now()->timezone("America/Mexico_City");
        $referrals = Referral::all();
        $year = strftime("%Y",strtotime($mytime->toDateString()));
        return view('newStudyRec',compact('types','year','doctors','referrals'));
    }

    public function store(Request $request)
    {   
        $id= intval($request->doctor_name);
        $doctor = Doctor::where('user_id',$id)->first();
        if(is_null($doctor)){
            $doctor = (object) [
                'id' => 0,
                'alias' => $request->doctor_name,
            ];
        }
        $study = Study::orderBy('id', 'desc')->first();
        $folio = 1;
        if(!is_null($study)){
            $folio = $study->folio + 1;
        }
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // Output: video-g6swmAP8X5VG4jCi.mp4
        $token = substr(str_shuffle($permitted_chars), 0, 31).$folio;
        $newStudy = Study::create([
            'doctor_id' => $doctor->id,
            'folio' => $folio,
            'patient_name' => strtoupper($request->patient_name),
            'paternal_surname' => strtoupper($request->paternal_surname),
            'maternal_surname' => strtoupper($request->maternal_surname),
            'patient_email' => strtolower($request->patient_email),
            'patient_phone' => $request->patient_phone,
            'observations' => $request->note,
            'status' => "Llegada",
            'qr' => $token,
            'total' => $request->total,
            'birthday' => $request->year."-".$request->month."-".$request->day,
            'internal' => 1,
            'referral' => $request->referral,
        ]);
        if($request->duration != '00:00'){
            $newStudy->duration  = $request->duration;
            $newStudy->save();
        }
        if($doctor->id == 0){
            $newStudy->doctor_name = $request->doctor_name;
            $newStudy->doctor_email = $request->doctor_email;
            $newStudy->save();
        }
        
        $newRecord = Record::create([
            'study_id' => $newStudy->id,
            'action' => "Recepción ha generado un nuevo estudio.",
            'user' => auth()->user()->name,
            'user_email' => auth()->user()->email,
            'folio' => $newStudy->folio,
        ]);
        //$newStudy->id
        $arrayStudies = [];
        foreach ($request->arrayType as $arrayType) {

            $newStudy_type = Study_type::create([
                'study_id' => $newStudy->id,
                'type_id' => request($arrayType),
            ]);
            $findType = Type::findOrFail($newStudy_type->type_id);
            $arrayQuestions = [];

            //$newStudy_type->id
            if(!is_null(request($arrayType.'question'))){
                foreach (request($arrayType.'question') as $question_id) {
                    if(!is_null(request($arrayType.'question'.$question_id))){
                        $findQuestion = Question::findOrFail($question_id);
                        $arrayAnswer = [];
                        if($findQuestion->kind == "texto"){

                            $newType_question = Type_question::create([
                                's_t_id' => $newStudy_type->id,
                                'question_id' => $question_id,
                                'answer' => request($arrayType.'question'.$question_id)
                            ]);
                            array_push($arrayAnswer,$newType_question->answer);
                        }else{
                            $newType_question = Type_question::create([
                                's_t_id' => $newStudy_type->id,
                                'question_id' => $question_id,
                            ]);
                            //$newType_question->id
                            if($findQuestion->kind == "radio"){
                                if($findQuestion->answer()->count() > 1){
                                    $newQuestion_answer = Question_answer::create([
                                        't_q_id' => $newType_question->id,
                                        'answer_id' => request($arrayType.'question'.$question_id),
                                    ]);
                                    $findAnswer = Answer::findOrFail($newQuestion_answer->answer_id);
                                    $newQuestion_answer->cost = $findAnswer->cost;
                                    $newQuestion_answer->save();
                                    array_push($arrayAnswer,$findAnswer->answer);
                                }else{
                                    foreach (request($arrayType.'question'.$question_id) as $answer_id) {
                                        $newQuestion_answer = Question_answer::create([
                                            't_q_id' => $newType_question->id,
                                            'answer_id' => $answer_id,
                                        ]);
                                        $findAnswer = Answer::findOrFail($newQuestion_answer->answer_id);
                                        $newQuestion_answer->cost = $findAnswer->cost;
                                        $newQuestion_answer->save();
                                        array_push($arrayAnswer,$findAnswer->answer);
                                    }
                                }
                                
                            }else{
                                foreach (request($arrayType.'question'.$question_id) as $answer_id) {
                                    $newQuestion_answer = Question_answer::create([
                                        't_q_id' => $newType_question->id,
                                        'answer_id' => $answer_id,
                                    ]);
                                    $findAnswer = Answer::findOrFail($newQuestion_answer->answer_id);
                                    $newQuestion_answer->cost = $findAnswer->cost;
                                    $newQuestion_answer->save();
                                    array_push($arrayAnswer,$findAnswer->answer);
                                }
                            }
                            
                        }
                        $objQuestion = (object)[
                            'question' => $findQuestion->question,
                            'answers' => $arrayAnswer,
                            'note' => $findQuestion->note,
                            'class_note' => $findQuestion->note,
                        ];
                        array_push($arrayQuestions,$objQuestion);
                    }
                }    
            }
            $objStudy = (object)[
                'title' => $findType->type,
                'questions' => $arrayQuestions,
                'note' => $findType->note,
                'class_note' => $findType->class_note,
            ];
        
            array_push($arrayStudies,$objStudy);

        }
    
        $details = [
            'qr' => $newStudy->qr,
            'name' => $newStudy->patient_name,
            'doctor' => $doctor->alias,
            'studies' => $arrayStudies,
            'notes' => $newStudy->observations,
            'duration' => $newStudy->duration, 
            'total' => sprintf('$ %s', number_format($newStudy->total, 2))
        ];

        Mail::to($request->patient_email)->send(new newStudy($details));
        //event(new hostEvent());

        return redirect()->route('recepcion')->with('success', 'study');
    }
}
