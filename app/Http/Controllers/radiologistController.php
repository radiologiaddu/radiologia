<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Study;
use App\Models\Radiologist;
use App\Models\Record;
use App\Models\FreeTime;
use App\Events\finishEvent;

class radiologistController extends Controller
{
    public function agenda()
    {
        $colors = array('Tomato','Aqua', 'BlueViolet', 'Brown', 'DarkCyan', 'DarkOrange','ForestGreen','Gold','HotPink');
        $today = date('Y-m-d');
        $dayWeek = date('w');
        $studies = Study::with('appointment','doctor')->where('status','Empezado')->where('date', $today)->orWhere('status','Realizado')->where('date', $today)->orWhere('status','Enviado')->where('date', $today)->orderBy('created_at', 'DESC')->get();
        $freesTime = FreeTime::where('date', $today)->get();
        if(is_null(FreeTime::orderBy('id', 'DESC')->first())){
            $idLast = 0;
        }else{
            $idLast = FreeTime::orderBy('id', 'DESC')->first()->id;
        }
        //$studies = Study::orderBy('created_at', 'DESC')->with('appointment','doctor')->take(10)->get();
        foreach($studies as $study){
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
                        'answers' => $arrayAnswer,
                        'note' => $question->note,
                        'class_note' => $question->class_note,
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
            $study->arrayStudies = $arrayStudies;
        }
        $radiologists = Radiologist::where('status', null)->orderBy('id')->get();
        $index = 0;
        foreach($radiologists as $radiologist){
            $radiologist->color = $colors[$index];
            $index++;
        }
        return view('agendaRadio',compact('studies','radiologists','today','dayWeek','freesTime','idLast'));
    }
    public function index()
    {
        $studies = Study::with('appointment','doctor')->where('status','Empezado')->orderBy('created_at', 'DESC')->get();
        foreach($studies as $study){
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
                        'answers' => $arrayAnswer,
                        'note' => $question->note,
                        'class_note' => $question->class_note,
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
            $study->arrayStudies = $arrayStudies;
        }
        
        $radiologists = Radiologist::where('status', null)->orderBy('id')->get();

        return view('dashboardRadio',compact('studies','radiologists'));
    }

    public function indexReload()
    {
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
        $opciones = "";
        $studies = Study::with('appointment','doctor')->where('status','Empezado')->orderBy('created_at', 'DESC')->get();
        foreach($studies as $study){
            $opciones .='<div class="divRadiologist col-md-6 col-sm-12" radiologo="'.$study->radiologist.'">
                            <div class="card card-border-c-blue">
                                <div class="card-header d-block">
                                    <a href="#!" class="text-secondary">';
                                    if ($study->internal == 1){
                                        $opciones .='R'.sprintf('%06d',$study->folio);
                                    }else{
                                        $opciones .='D'.sprintf('%06d',$study->folio);
                                    }
                                    $opciones .=' - '.$study->patient_name.' '.$study->paternal_surname.' '.$study->maternal_surname.'</a>
                                    <br>
                                    <strong>Cita:</strong> ';
                                    if(isset($study->appointment)){
                                        $opciones .=$weekMap[strftime("%w",strtotime($study->appointment->date))].' '.
                                        strftime("%d",strtotime($study->appointment->date)).' '.
                                        strtoupper($months[strftime("%m",strtotime($study->appointment->date))]).' '.
                                        strftime("%Y",strtotime($study->appointment->date)).' - '.
                                        $study->appointment->time. " hrs.";
                                    }else{
                                        $opciones .="Sin agendar cita";
                                    }
                                    $opciones .='
                                    <div class="row">
                                        <div class="col-md-6">'.
                                            $study->patient_email.'
                                            <br>'.
                                            $study->patient_phone.'
                                        </div>';
                                        if (isset($study->birthday)) {
                                        $opciones .='
                                        <div class="col-md-6">'.
                                            strftime("%d",strtotime($study->birthday)).' '.
                                            strtoupper($months[strftime("%m",strtotime($study->birthday))]).' '.
                                            strftime("%Y",strtotime($study->birthday)).'
                                            <br>
                                            Edad: '.($study->edad()  + 0).' Años
                                        </div>';
                                        }
                                    $opciones .='
                                    </div>
                                    <div class="row">
                                        <div class="mt-1 text-center col-12">
                                            Doctor
                                        </div>
                                        <div class="text-justify">';
                                        if ($study->doctor_id == 0){
                                            $opciones .='<div class="col-12">'.$study->doctor_name.'</div>';
                                        }else{
                                            $opciones .='<div class="col-12">'.$study->doctor->alias.'</div>
                                            <div class="col-12">'.$study->doctor->user->name.' '.$study->doctor->paternalSurname.' '.$study->doctor->maternalSurname.'</div>';
                                        }
                                        $opciones .='
                                        </div>
                                    </div>
                                    <div class="mt-1">
                                        <p class="task-due"><strong> Radiólogo: </strong><strong class="label label-primary">'.$study->radiologist.'</strong></p>
                                    </div>
                                </div>
                                <div class="card-block card-task pt-0">
                                    <div class="row">
                                        <div class="col-sm-12">';
                                        foreach($study->study_type as $study_type){
                                            $type = $study_type->type;
                                            $opciones .='
                                            <div class="mt-3 mb-3">'.
                                                $type->type;
                                            foreach($study_type->type_question as $type_question){
                                                $question = $type_question->question;
                                                $opciones .='
                                                <div class="mb-3">'.
                                                    $question->question.'
                                                </div>';

                                                if($question->kind == "texto"){
                                                $opciones .='
                                                <div class="mb-3" style="color:rgb(110,123,222);font-weight: 900;">
                                                    <li>'.
                                                        $type_question->answer.'
                                                    </li>
                                                </div>';
                                                }else{
                                                    foreach($type_question->question_answer as $question_answer){
                                                        $answer = $question_answer->answer;
                                                        $opciones .='
                                                        <div class="mb-3" style="color:rgb(110,123,222);font-weight: 900;">
                                                            <li>'.
                                                                $answer->answer.'
                                                            </li>
                                                        </div>';
                                                    }
                                                }

                                            } 
                                            $opciones .='
                                            </div>';
                                            if(!is_null($type->class_note)){
                                                if($type->class_note == "simpleNote"){
                                                    $opciones .='
                                                    <div class="form-group mt-3">
                                                        <label class="form-check-label" for="simpleNote" style="font-size: 14px;">
                                                            '.nl2br($type->note).'                      
                                                        </label>
                                                    </div>';
                                                }else{
                                                    $opciones .='
                                                    <div class="form-group mt-3">
                                                        <label class="form-check-label" for="highlightedNote" style="font-size: 14px;">
                                                            <div style="background: rgb(110,123,222);
                                                            border-radius: 50%;
                                                            height: 30px;
                                                            width: 30px;
                                                            text-align: center;
                                                            align-items: center;
                                                            display: flex;
                                                            float: left;">
                                                                <img src="https://app.ddu.mx/image/blanco100.png" style="width: 20px;
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
                                                            display: flex;">'.
                                                            nl2br($type->note).'                         
                                                            </span>
                                                            <div class="clearfix"></div>
                                                        </label>
                                                    </div>';
                                                }
                                            }
                                        }
                                        $opciones .='
                                        </div>
                                    </div>
                                <div class="row">
                                    <strong>Observaciones adicionales:</strong> 
                                    <div class="col-12">'.
                                        nl2br($study->observations).'
                                    </div>
                                </div>
                                <hr>
                                <div class="task-list-table">
                                    <button class="btn btn-primary btn-sm finish" type="button" id="'.$study->qr.'" >TERMINAR ESTUDIO</button>
                                </div>
                            </div>
                        </div>
                    </div>';
                    
            $arrayStudies = [];
            $study->arrayStudies = $arrayStudies;
        }
        return $opciones;      
    }

    public function finish (Request $request)
    {
        $id = $request->id;
        $study = Study::where('qr',$id)->first();

        if($study->status == 'Empezado'){
            $study->status = 'Realizado';
            $study->save();
            $newRecord = Record::create([
                'study_id' => $study->id,
                'action' => "El estudio ha sido terminado",
                'user' => $study->radiologist,
                'user_email' => auth()->user()->email,
                'folio' => $study->folio,
            ]);

            if ($study->internal == 1){
                $letter = "R";
            }else{
                $letter = "D";
            }
            event(new finishEvent("button".$letter.sprintf('%06d',$study->folio)));
            return true;
        }
        return false;
    }
}
