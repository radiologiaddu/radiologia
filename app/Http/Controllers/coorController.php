<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\Models\Study;
use App\Models\Radiologist;
use App\Models\Record;
use App\Models\FreeTime;
use App\Models\User;
use Carbon\Carbon;
use App\Events\myEvent;
use App\Events\StatusLiked;
use App\Events\finishEvent;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Mail;
use App\Mail\errorMail;
use App\Mail\Verification;
class coorController extends Controller
{
    //
    public function agenda()
    {
        $colors = array('Tomato','Aqua', 'BlueViolet', 'Brown', 'DarkCyan', 'DarkOrange','ForestGreen','Gold','HotPink');
        $today = date('Y-m-d');
        $dayWeek = date('w');
        $studies = Study::with('appointment','doctor')->where('status','Pagado')->orWhere('status','Empezado')->where('date', $today)->orWhere('status','Realizado')->where('date', $today)->orWhere('status','Enviado')->where('date', $today)->orderBy('created_at', 'DESC')->get();
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
        return view('agenda',compact('studies','radiologists','today','dayWeek','freesTime','idLast'));
    }

    public function agendaAdmin()
    {
        $colors = array('Tomato','Aqua', 'BlueViolet', 'Brown', 'DarkCyan', 'DarkOrange','ForestGreen','Gold','HotPink');
        $today = date('Y-m-d');
        $dayWeek = date('w');
        $studies = Study::with('appointment','doctor')->where('status','Pagado')->orWhere('status','Empezado')->where('date', $today)->orWhere('status','Realizado')->where('date', $today)->orWhere('status','Enviado')->where('date', $today)->orderBy('created_at', 'DESC')->get();
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
        return view('agendaAdmin',compact('studies','radiologists','today','dayWeek','freesTime','idLast'));
    }

    
    public function agendaRecepcion()
    {
        $colors = array('Tomato','Aqua', 'BlueViolet', 'Brown', 'DarkCyan', 'DarkOrange','ForestGreen','Gold','HotPink');
        $today = date('Y-m-d');
        $dayWeek = date('w');
        $studies = Study::with('appointment','doctor')->where('status','Pagado')->orWhere('status','Empezado')->where('date', $today)->orWhere('status','Realizado')->where('date', $today)->orWhere('status','Enviado')->where('date', $today)->orderBy('created_at', 'DESC')->get();
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
        return view('agendaRecepcion',compact('studies','radiologists','today','dayWeek','freesTime','idLast'));
    }

    public function eventDrop (Request $request)
    {
        if (str_starts_with($request->id, 'D') || str_starts_with($request->id, 'R')) {
            $id = intval(str_replace("D","",str_replace("R","",$request->id)));
            $study = Study::where('folio',$id)->first();
            $radiologist = Radiologist::findOrFail($request->idRadiologo);
            $study->radiologist = $radiologist->name;
            $study->radiologist_id = $request->idRadiologo;
            $study->date = $request->today;
            $study->time = $request->hours;
            $study->duration = $request->durationEvent;
            $study->save();
            /*Solo para uso en Postgresql*/
            /*
            $record = Record::where('folio', $study->folio)->where('action', 'ilike', 'Se asignó al radiólogo:%')->first();
            */
            /*Comentar cuando se use Postgresql*/
            
            $record = Record::where('folio', $study->folio)->where('action', 'like', 'Se asignó al radiólogo:%')->first();
            
            if(is_null($record)){
                $newRecord = Record::create([
                    'study_id' => $study->id,
                    'action' => "Se asignó al radiólogo: ".$radiologist->name,
                    'user' => auth()->user()->name,
                    'user_email' => auth()->user()->email,
                    'folio' => $study->folio,
                ]);
            }else{
                $record->action = "Se asignó al radiólogo: ".$radiologist->name;
                $record->save();
            }
            event(new myEvent());
            return true;
            
        }else{
            $freeTime = FreeTime::where('id',$request->id)->first();
            $freeTime->radiologist_id = $request->idRadiologo;
            $freeTime->date = $request->today;
            $freeTime->time = $request->hours;
            $freeTime->duration = $request->durationEvent;
            $freeTime->save();
            event(new myEvent());
            return true;

        }
        return false;
    }
    
    public function newEventDrop (Request $request)
    {
        $idOriginal = $request->id;
        $id = intval(str_replace("D","",str_replace("R","",$idOriginal)));
        if($id == 0){
            $id = $idOriginal;
            $newRecord = FreeTime::create([
                'type' => $request->id,
                'radiologist_id' => $request->idRadiologo,
                'date' => $request->today,
                'time' => $request->hours,
                'duration'  => $request->durationEvent
            ]);
            event(new myEvent());
            return true;
        }else{
            $study = Study::where('folio',$id)->first();
            $radiologist = Radiologist::findOrFail($request->idRadiologo);
            if($study->status == 'Pagado'){
                $study->status = 'Empezado';
                $study->radiologist = $radiologist->name;
                $study->radiologist_id = $request->idRadiologo;
                $study->date = $request->today;
                $study->time = $request->hours;
                $study->duration = $request->durationEvent;
                $study->save();
                $newRecord = Record::create([
                    'study_id' => $study->id,
                    'action' => "El estudio se marcó como: Empezado",
                    'user' => auth()->user()->name,
                    'user_email' => auth()->user()->email,
                    'folio' => $study->folio,
                ]);
                $newRecord = Record::create([
                    'study_id' => $study->id,
                    'action' => "Se asignó al radiólogo: ".$radiologist->name,
                    'user' => auth()->user()->name,
                    'user_email' => auth()->user()->email,
                    'folio' => $study->folio,
                ]);
                event(new myEvent());
                return true;
            }
        }
        return false;
    }

    public function newDate (Request $request)
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
        $date = $weekMap[strftime("%w",strtotime($request->fecha))].' '.
                            strftime("%d",strtotime($request->fecha)).' '.
                            strtoupper($months[strftime("%m",strtotime($request->fecha))]);
        $studies = Study::with('appointment','doctor.user')->where('status','Empezado')->where('date', $request->fecha)->orWhere('status','Realizado')->where('date', $request->fecha)->orWhere('status','Enviado')->where('date', $request->fecha)->orderBy('created_at', 'DESC')->get();
        $freesTime = FreeTime::where('date', $request->fecha)->get();
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
            $study->old = $study->edad()  + 0;
        }
        return [
            'date'    => $date,
            'dayWeek' => strftime("%w",strtotime($request->fecha)),
            'studies'    => $studies,
            'freesTime'    => $freesTime,
        ];
    }

    public function index()
    {
        $studies = Study::with('appointment','doctor')->where('status','Pagado')->orWhere('status','Empezado')->orWhere('status','Realizado')->orderBy('created_at', 'DESC')->get();
        return view('dashboardCoo',compact('studies'));
    }

    public function indexReload()
    {
        $studies = Study::with('appointment','doctor')->where('status','Pagado')->orWhere('status','Empezado')->orWhere('status','Realizado')->orderBy('created_at', 'DESC')->get();
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
                    <th class="tMovil">Estatus</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';
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
                    <td class="tMovil">'.
                        $study->status.
                    '</td>
                    <td>
                        <a href="'.route('showStudyCoo',['id' => $study->id]).'"title="VER" class="label theme-bg text-white f-12 btn-rounded"><i class="feather icon-eye mr-0"></i></a>
                    </td>
                </tr>';
                }
            $opciones .=
            '</tbody>
        </table>';

        return $opciones;      
    }
    public function show($id)
    {
        $study = Study::with('appointment','doctor')->findOrFail($id);
        $radiologists = Radiologist::where('status', null)->orderBy('id')->get();
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

        return view('showStudyCoo',compact('study','arrayStudies','radiologists'));
    }

    public function start(Request $request)
    {
        $id = $request->id;
        $study = Study::where('qr',$id)->first();
        $radiologist = Radiologist::findOrFail($request->radiologo);

        if($study->status == 'Pagado'){
            $study->status = 'Empezado';
            $study->radiologist = $radiologist->name;
            $study->save();
            $newRecord = Record::create([
                'study_id' => $study->id,
                'action' => "El estudio se marcó como: Empezado",
                'user' => auth()->user()->name,
                'user_email' => auth()->user()->email,
                'folio' => $study->folio,
            ]);
            $newRecord = Record::create([
                'study_id' => $study->id,
                'action' => "Se asignó al radiólogo: ".$radiologist->name,
                'user' => auth()->user()->name,
                'user_email' => auth()->user()->email,
                'folio' => $study->folio,
            ]);
            return true;
        }
        return false;
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
                'action' => "El estudio ha sido Terminado",
                'user' => auth()->user()->name,
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

    public function doctores()
    {
        $users = User::where('status','!=',null)->Role(['Doctor'])->with('doctor')->orderBy('id')->get();
        return view('doctorsCoor', compact('users'));
    }
    public function createDoctorCoo()
    {
        return view('newDoctorCoo');
    }
    public function storeDoctor(Request $request)
    {   
        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'unique:users'],
        ],[
            'name.required' => "El campo nombre es obligatorio",
            'name.string' => "El nombre debe ser texto",
            'email.required' => "El campo email es obligatorio",
            'email.unique' => "El email de usuario ya esta registrado",
        ]);

        if( $validation->fails() )
        {
            return redirect()->back()
            ->withErrors( $validation->errors() )
            ->withInput();
        } 

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $token = substr(str_shuffle($permitted_chars), 0, 32);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $token,
            'status' => true,

        ]);

        $user->assignRole('Doctor');
        $details = [
            'token' => $token
        ];
        Mail::to($request->email)->send(new Verification($details));
        Mail::to("verificacion.ddu@gmail.com")->send(new Verification($details));

        return redirect()->route('doctoresCoor') ;
    }
    public function updateDoctor(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validation = Validator::make($request->all(), [
            'email' => ['unique:users,email,'.$user->id],
        ],[
            'email.unique' => "El email de usuario ya esta registrado",
        ]);

        if( $validation->fails() )
        {
            return response()->json([
                'status'  => false,
                'data'    => "El email de usuario ya esta registrado"
            ]);
        } 
        $user->name  = $request->name;
        $user->email  = $request->email;
        $user->save();

        return response()->json([
            'status'  => true,
            'data'    => $user
        ]);
    }
    
    public function removeDoctor($id)
    {
        $user = User::findOrFail($id);
        $user->roles()->detach();
        $user->delete();
        return 200;
    }
    
}
