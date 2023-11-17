<?php

namespace App\Http\Controllers;
use App\Models\Study;
use App\Models\Record;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Type;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Study_type;
use App\Models\Type_question;
use App\Models\Question_answer;
use Illuminate\Support\Facades\Mail;
use App\Mail\newStudy;
use App\Events\hostEvent;

use Illuminate\Http\Request;

class HostessController extends Controller
{
    public function index()
    {
        $mytime = Carbon::now()->timezone("America/Mexico_City")->subDays(46);
        $studies = Study::with('appointment','doctor')->where('status','Creado')->where( 'created_at', '>',$mytime)->orWhere('status','Agendado')->where( 'created_at', '>',$mytime)->orderBy('created_at', 'DESC')->get();
        $page = "Nuevos";
        return view('dashboardHost',compact('studies','page'));
    }

    public function past()
    {
        $mytime = Carbon::now()->timezone("America/Mexico_City")->subDays(46);
        $studies = Study::with('appointment','doctor')->where('status','Creado')->where( 'created_at', '<=',$mytime)->orWhere('status','Agendado')->where( 'created_at', '<=',$mytime)->orderBy('created_at', 'DESC')->get();
        $page = "Pasados";
        return view('dashboardHost',compact('studies','page'));
    }

    public function prices()
    {
        $types = Type::with('questions')->get();
        $arrayType = [];
        foreach($types as $type){
            $arrayQuestion = [];
            foreach($type->questions as $question){
                $arrayAnswer = [];
                foreach($question->answer as $answer){
                    if(!is_null($answer->cost)){
                        $objAnswer = (object)[
                            'answer' => $answer->answer,
                            'cost' => $answer->cost,
                        ];
                        array_push($arrayAnswer,$objAnswer);
                    }   
                }
                if(!empty($arrayAnswer)){
                    $objQuestion = (object)[
                        'question' => $question->question,
                        'answer' => $arrayAnswer
                    ];
                    array_push($arrayQuestion,$objQuestion);
                }
            }

            if(!empty($arrayQuestion)){
                $objType = (object)[
                    'type' => $type->type,
                    'question' => $arrayQuestion
                ];
                array_push($arrayType,$objType);
            }
        }
        $page = "Precios";
        return view('prices',compact('arrayType','page'));
    }

    public function indexReload(Request $request)
    {
        $mytime = Carbon::now()->timezone("America/Mexico_City")->subDays(46);
        if($request->page == "Nuevos"){
            $studies = Study::with('appointment','doctor')->where('status','Creado')->where( 'created_at', '>',$mytime)->orWhere('status','Agendado')->where( 'created_at', '>',$mytime)->orderBy('created_at', 'DESC')->get();
        }else{
            $studies = Study::with('appointment','doctor')->where('status','Creado')->where( 'created_at', '<=',$mytime)->orWhere('status','Agendado')->where( 'created_at', '<=',$mytime)->orderBy('created_at', 'DESC')->get();
        }
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
                        <th class="tMovil">Folio</th>
                        <th>Paciente</th>
                        <th class="tMovil">Cita</th>
                        <th class="tMovil">Recibido hace</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
        ';
        
                foreach ($studies as $study){
                $opciones .= '
                <tr>
                    <td class="tMovil">';
                    if ($study->internal == 1){
                        $opciones .='R'.sprintf('%06d',$study->folio);
                    }else{
                        $opciones .='D'.sprintf('%06d',$study->folio);
                    }
                    $opciones .='</td>
                    <td>'.$study->patient_name.' '.$study->paternal_surname.' '.$study->maternal_surname.'</td>
                    <td class="tMovil">';
                        if (isset($study->appointment)){
                            $opciones .= '<span class="d-none">'.$study->appointment->date.' '.$study->appointment->time.'</span>';
                            $opciones .= 
                            $weekMap[strftime("%w",strtotime($study->appointment->date))].' '.
                            strftime("%d",strtotime($study->appointment->date)).' '.
                            strtoupper($months[strftime("%m",strtotime($study->appointment->date))]).' '.
                            strftime("%Y",strtotime($study->appointment->date)).
                            '<br>'.
                            $study->appointment->time;
                        }else{
                            $opciones .= 'Sin agendar cita';
                        }
                    $opciones .= '
                    </td>
                    <td class="tMovil">';
                        $opciones .= '<span class="d-none">'.$study->created_at.'</span>';
                        if (($study->dias() + 0) == 0){
                            if (($study->horas() + 0) == 0){
                                $opciones .= ($study->minutos() + 0). ' Minutos';

                            }else{
                                $opciones .= ($study->horas() + 0). ' Horas';
                            }
                        }else{
                            $opciones .= ($study->dias() + 0) . ' Días';

                        }   
                    $opciones .= '  
                    </td>
                    <td>
                        <a href="'.route('statusAppointment',['id' => $study->qr]).'" class="label theme-bg text-white f-12 btn-rounded"><i class="feather icon-eye mr-0"></i></a>
                    </td>
                </tr>';
                }
            $opciones .= ' 
            </tbody>
        </table>';
        return $opciones;      
    }
    public function create()
    {
        $doctors = User::Role(['Doctor'])->with('doctor')->orderBy('id')->where('email_verified_at','!=',null)->get();
        $types = Type::orderBy('id')->get();
        $mytime = Carbon::now()->timezone("America/Mexico_City");
        $year = strftime("%Y",strtotime($mytime->toDateString()));
        return view('newStudyHostess',compact('types','year','doctors'));
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
            'status' => "Creado",
            'qr' => $token,
            'total' => $request->total,
            'birthday' => $request->year."-".$request->month."-".$request->day,
            'internal' => 1
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
            'action' => "El hostess ha generado un nuevo estudio.",
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
                                    array_push($arrayAnswer,$findAnswer->answer);
                                    $newQuestion_answer->cost = $findAnswer->cost;
                                    $newQuestion_answer->save();
                                }else{
                                    foreach (request($arrayType.'question'.$question_id) as $answer_id) {
                                        $newQuestion_answer = Question_answer::create([
                                            't_q_id' => $newType_question->id,
                                            'answer_id' => $answer_id,
                                        ]);
                                        $findAnswer = Answer::findOrFail($newQuestion_answer->answer_id);
                                        array_push($arrayAnswer,$findAnswer->answer);
                                        $newQuestion_answer->cost = $findAnswer->cost;
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
                                    array_push($arrayAnswer,$findAnswer->answer);
                                    $newQuestion_answer->cost = $findAnswer->cost;
                                    $newQuestion_answer->save();
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
        event(new hostEvent());

        return redirect()->route('newStudyHostess')->with('success', 'study');
    }
}
